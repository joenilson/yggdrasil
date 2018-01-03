<?php
/**
 * Copyright (C) 2017 Joe Nilson joenilson at gmail dot com
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation, version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Login;
use App\Entity\User;
use App\Functions\BaseConfig;
use DateTime;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller to config the system when is installed first time
 */
class ConfigController extends BaseController
{

    public $parameters_file;

    /**
     * Function to config the database and confirm that it is set
     *
     * @param Request $request
     * @return void
     */
    public function configSystem(Request $request)
    {
        $status = $this->confirmDatabaseConfig($_SERVER['DATABASE_URL']);
        if ($status == 'app-db-created-success') {
            return $this->redirectToRoute('home');
        }

        $enviroment = [];
        $action = $request->get('action');
        if ($action == 'save') {
            $enviroment['APP_ENV'] = (null !== $request->get('config_dev')) ? 'dev' : 'prod';
            $enviroment['APP_SECRET'] = $this->generateRandomString(32);
            $enviroment['DATABASE_URL'] = $request->get('dbtype') . '://' . $request->get('dbuser') . ':' . $request->get('dbpass') . '@' . $request->get('dbhost') . ':' . $request->get('dbport') . '/' . $request->get('dbname').'?charset=UTF-8';
            $enviroment['database_user'] = $request->get('dbuser');
            $enviroment['database_password'] = $request->get('dbpass');
            $enviroment['database_host'] = $request->get('dbhost');
            $enviroment['database_port'] = $request->get('dbport');
            $enviroment['database_name'] = $request->get('dbname');
            $enviroment['database_driver'] = "pdo_" . $request->get('dbtype');
            
            if ($status == 'app-db-non-exists') {
                return $this->createDatabaseStructure($enviroment);
            }
        }

        $this->readParametersFile();
        //$filecontents = null;
        return $this->render('config/system.html.twig', [
                'status' => $status,
                'filecontents' => $this->parameters_file,
                'database_url' => (isset($_SERVER['DATABASE_URL'])) ? true : false
        ]);
    }

    /**
     * Function to verify if the database is created and can be connected
     *
     * @param [type] $db
     * @return void
     */
    public function confirmDatabaseConfig($db)
    {
        return BaseConfig::verifyDatabase($db);
    }

    /**
     * Function to create the database if it isn't created
     *
     * @param [type] $env
     * @return void
     */
    public function createDatabaseStructure($env)
    {
        $status = BaseConfig::createDatabase($env);
        if ($status == 'app-db-created-success') {
            $this->changeEnv($env);
            $this->createSystemTables($env);
            return $this->redirectToRoute('home');
        }
        return $this->render('config/system.html.twig', [
                'status' => $status
        ]);
    }

    /**
     * Function to write the database configuration in the parameters.yml file
     *
     * @param type $data
     * @return boolean
     */
    protected function changeEnv($data = array())
    {
        if (count($data) > 0) {

            // Read .env-file
            $dir = dirname(dirname(dirname(__FILE__)));
            $parameters_file = $dir . DIRECTORY_SEPARATOR . '.env';
            $pre_env = file_get_contents($parameters_file);

            // Split string on every " " and write into array
            $env = explode("\n", $pre_env);
            
            // Loop through given data
            foreach ((array) $data as $key => $value) {

                // Loop through .env-data
                foreach ($env as $env_key => $env_value) {

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if ($entry[0] == $key) {
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $edited_env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents($parameters_file, $edited_env);
            (new Dotenv())->load($parameters_file);
            return true;
        } else {
            return false;
        }
    }

    public function readParametersFile()
    {
        $dir = dirname(dirname(dirname(__FILE__)));
        $parameters_file = $dir . DIRECTORY_SEPARATOR . '.env';
        $parameters_file_orig = $dir . DIRECTORY_SEPARATOR . '.env.dist';
        $file_contents = [];

        $gestor = fopen($parameters_file_orig, "r");
        $archivo = $parameters_file_orig;
        if (file_exists($parameters_file)) {
            $gestor = fopen($parameters_file, "r");
            $archivo = $parameters_file;
        }

        if ($gestor) {
            $file_contents[] = "Archivo: $archivo";
            while (($buffer = fgets($gestor, 4096)) !== false) {
                $content = explode("=", $buffer);
                if (isset($content[1])) {
                    $file_contents[$content[0]] = $content[1];
                } else {
                    $file_contents[] = $buffer;
                }
            }

            fclose($gestor);
        }
        $this->parameters_file = $file_contents;
    }

    /**
     * Auxiliar function to generate the secretKey for the server
     *
     * @param integer $length
     * @return void
     */
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Function to create the system tables from the orm.yml files generated by doctrine
     * this files are only used to generate the tables in the rdbms MySQL or PostgreSQL
     * at this time
     *
     * @param [type] $db
     * @return void
     */
    public function createSystemTables()
    {
        $em = $this->getDoctrine()->getManager();

        $cmf = new DisconnectedClassMetadataFactory();
        $cmf->setEntityManager($em);
        
        $driver = $em->getConfiguration()->getMetadataDriverImpl();
        
        $classes = $driver->getAllClassNames();
        $metadata = array();
        foreach ($classes as $class) {
            $metadata[] = $cmf->getMetadataFor($class);
        }

        $schema = new SchemaTool($em);
        $schema->createSchema($metadata);

        $this->createAdminUser();
    }

    /**
     * Function to create the admin user the first time, this user will have as login/password
     * the words admin/admin and this must to be changed the first time
     *
     * @return void
     */
    public function createAdminUser()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@asgard.local');
        $user->setFirstname('System');
        $user->setLastname('Admin');
        $user->setLocale("en");
        $user->setDateCreation(new DateTime("now"));
        $user->setUserCreation('system');
        $user->setStatus('A');
        $user->setImage(null);
        $em->persist($user);

        $login = new Login();
        $login->setUsername('admin');

        $encodedPassword = $this->passencoder->encodePassword($login, 'admin');
        $login->setPassword($encodedPassword);
        $em->persist($login);
        $flush = $em->flush();
        if ($flush == null) {
            $this->addFlash(
                'notice', 'app-config-default-user'
            );
        } else {
            $this->addFlash(
                'warning', 'app-config-default-user-fail'
            );
        }
    }

    /**
     * Action Function to make a system setup post installation
     * here must be setted the timezone, language and modules to activate
     *
     * @return void
     */
    public function optionsSystem()
    {
        return $this->render('config/options_system.html.twig', [
        ]);
    }
}
