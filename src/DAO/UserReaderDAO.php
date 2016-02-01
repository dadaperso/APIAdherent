<?php
/**
 * Created by PhpStorm.
 * User: dada
 * Date: 15/01/2016
 * Time: 18:46
 */

namespace WebService\DAO;

use WebService\Entity\User;

class UserReaderDAO extends \EasyCSV\Reader
{

    /**
     * Retrouve le user depuis son indentifiant
     *
     * @return null|User
     */
    public function getRowById($id)
    {
        $notFound = true;
        $user = null;

        $aUser = $this->getRow();

        // déroule le fichier pour trouvé l'identifiant
        do{
            $aUser = explode(';',current($aUser));

            if($aUser[0] == $id)
            {
                $user = User::hydrate($aUser);
                $notFound = false;
            }
        }while(($aUser = $this->getRow()) && $notFound); // s'arrte quand le fichier est terminer ou quand l'user est trouvé


        return $user;
    }

    /**
     * Lis le fichier et retourne un tableau de User
     *
     * @return User[]
     */
    public function getAll()
    {
        $data = array();
        while ($row = $this->getRow()) {
            $data[] = User::hydrate(explode(';',current($row)));
        }

        return $data;
    }


}