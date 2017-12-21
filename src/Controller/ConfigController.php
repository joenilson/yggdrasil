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
use App\Functions\DB\Connection;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\EntityGenerator;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Controller to config the system when is installed first time
 */
class ConfigController extends BaseController
{
    /**
     * Function to config the database and confirm that it is set
     *
     * @param Request $request
     * @return void
     */
    public function configSystem(Request $request)
    {
        $appConfig = [
            'dbhost'=> $_SERVER['database_host'],
            'dbport'=> $_SERVER['database_port'],
            'dbname'=> $_SERVER['database_name'],
            'dbuser'=> $_SERVER['database_user'],
            'dbpass'=> $_SERVER['database_password'],
            'dbtype'=> $_SERVER['database_driver']
        ];

        //$status = $this->confirmDatabaseConfig($appConfig);
        $status = $this->confirmDatabaseConfig($_SERVER['DATABASE_URL']);
        if($status == 'app-db-created-success'){
            return $this->redirectToRoute('home');
        }

        $db = [];
        $action = $request->get('action');
        if($action == 'save'){
            $db['dbuser'] = $request->get('dbuser');
            $db['dbpass'] = $request->get('dbpass');
            $db['dbhost'] = $request->get('dbhost');
            $db['dbname'] = $request->get('dbname');
            $db['dbtype'] = $request->get('dbtype');

            if($status == 'app-db-non-exists'){
                return $this->createDatabaseStructure($db);
            }
        }

        $filecontents = $this->createParametersFile($db);
        //$filecontents = null;
        return $this->render('config/system.html.twig',[
            'status' => $status,
            'filecontents' => $filecontents,
            'database_url'=>(isset($_SERVER['DATABASE_URL']))?true:false
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
     * @param [type] $db
     * @return void
     */
    public function createDatabaseStructure($db)
    {
        $status = BaseConfig::createDatabase($db);
        if($status == 'app-db-created-success'){
            $this->createParametersFile($db);
            $this->createSystemTables($db);
            return $this->redirectToRoute('home');
        }
        return $this->render('config/system.html.twig',[
            'status' => $status
        ]);
    }

    /**
     * Function to write the database configuration in the parameters.yml file
     *
     * @param [type] $db
     * @return void
     */
    protected function createParametersFile($db)
    {
        $dir = dirname(dirname(dirname(__FILE__)));
        $parameters_file = $dir.DIRECTORY_SEPARATOR.'.env-local';
        $parameters_file_orig = $dir.DIRECTORY_SEPARATOR.'.env.dist';
        $file_contents = [];

        $gestor = fopen($parameters_file_orig, "r");
        $archivo = $parameters_file_orig;
        if(file_exists($parameters_file)){
            $gestor = fopen($parameters_file, "r");
            $archivo = $parameters_file;
        }

        if ($gestor) {
            $file_contents[] = "Archivo: $archivo";
            while (($buffer = fgets($gestor, 4096)) !== false) {
                $content = explode("=", $buffer);
                if(isset($content[1])){
                    $file_contents[] = $content[0].' = '.$content[1];
                }else{
                    $file_contents[] = $buffer;
                }
            }

            fclose($gestor);
        }
        //$file_contents = file_get_contents($parameters_file);
        return $file_contents;
        /*
        fputs($fp,sprintf("parameters:\n\r"));
        fputs($fp,sprintf("%4sdatabase_driver: pdo_%s\n\r", '',$db['dbtype']));
        fputs($fp,sprintf("%4sdatabase_host: %s\n\r", '',$db['dbhost']));
        fputs($fp,sprintf("%4sdatabase_port: %s\n\r", '',($db['dbtype']=='pgsql')?5432:3306));
        fputs($fp,sprintf("%4sdatabase_name: %s\n\r", '',$db['dbname']));
        fputs($fp,sprintf("%4sdatabase_user: %s\n\r", '',$db['dbuser']));
        fputs($fp,sprintf("%4sdatabase_password: %s\n\r", '',$db['dbpass']));
        fputs($fp,sprintf("%4smailer_transport: smtp\n\r", ""));
        fputs($fp,sprintf("%4smailer_host: 127.0.0.1\n\r", ""));
        fputs($fp,sprintf("%4smailer_user: null\n\r", ""));
        fputs($fp,sprintf("%4smailer_password: null\n\r", ""));
        fputs($fp,sprintf("%4ssecret: %s\n\r",'',$this->generateRandomString(32)));
        fclose($fp);
        chmod($parameters_file, 0755);
         *
         */
    }

    /**
     * Auxiliar function to generate the secretKey for the server
     *
     * @param integer $length
     * @return void
     */
    public function generateRandomString($length = 10) {
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
    public function createSystemTables($db)
    {
        $connectionParams = array(
            'dbname'    => $db['dbname'],
            'user'      => $db['dbuser'],
            'password'  => $db['dbpass'],
            'host'      => $db['dbhost'],
            'driver'    => 'pdo_'.$db['dbtype'],
            'ssl'       => false
        );

        $paths = [
            dirname(dirname(__FILE__)).\DIRECTORY_SEPARATOR.'Resources'.\DIRECTORY_SEPARATOR.'config'.\DIRECTORY_SEPARATOR.'doctrine'
        ];

        $em = $this->getDoctrine()->getManager();

        $cmf = new DisconnectedClassMetadataFactory();
        $cmf->setEntityManager($em);

        $driver = $em->getConfiguration()->getMetadataDriverImpl();

        $classes = $driver->getAllClassNames();
        $metadata = array();
        foreach ($classes as $class) {
            $metadata[] = $cmf->getMetadataFor($class);
        }

        $schema = new \Doctrine\ORM\Tools\SchemaTool($em);
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
        $user->setDateCreation(new \DateTime("now"));
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
        if($flush==null){
            $this->addFlash(
                'notice',
                'app-config-default-user'
            );
        }else{
            $this->addFlash(
                'warning',
                'app-config-default-user-fail'
            );
        }

    }

    /**
     * Action Function to make a system setup post installation
     * here must be setted the timezone, language and modules to activate
     *
     * @return void
     */
    public function optionsSystemAction()
    {
        return $this->render('config/options_system.html.twig',[

        ]);
    }

}