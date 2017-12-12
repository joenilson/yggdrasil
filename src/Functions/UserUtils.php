<?php
/**
 * Copyright (C) 2017 Joe Nilson <joenilson at gmail dot com>
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation, version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Functions;

class UserUtils
{
    public function verifyChangePassword($form, $encoder, $user, $em, $request)
    {
        $username = $form->get('username')->getData();
        $oldpassword = $form->get('oldpassword')->getData();
        $password = $form->get('password')->getData();
                
        if($encoder->isPasswordValid($user->getPassword(), $oldpassword, $user->getSalt())) {
            $newPassword = $encoder->encodePassword($password,$user->getSalt());
            $user->setPassword($newPassword);
            $em->persist($user);
            $flush = $em->flush();
            if($flush) {
                $request->getSession()->getFlashbag()->add('warning','app-user-password-change-error');
            }else {
                $request->getSession()->getFlashbag()->add('success','app-user-password-change-success');
            }
        } else {
            $request->getSession()->getFlashbag()->add('warning','app-user-password-dont-match');
            
        }
    }

    public function verifyFirstPassword($encoder, $user, $request){
        if(!$encoder->isPasswordValid($user->getPassword(), 'admin', $user->getSalt())){
            return 'admin-password-is-not-default';
        }
        return 'admin-password-is-default';
    }
}