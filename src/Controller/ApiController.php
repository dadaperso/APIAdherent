<?php
/**
 * Created by PhpStorm.
 * User: dada
 * Date: 15/01/2016
 * Time: 18:44
 */

namespace WebService\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use WebService\DAO\UserReaderDAO;


class ApiController
{

    /**
     *
     * Returns the information to the user through its identifier
     *
     * @param Application $app
     * @param $id
     *
     */
    public function userViewAction(Application $app, $id)
    {
        /** @var UserReaderDAO $userReaderDAO */
        $userReaderDAO = $app['dao.user.reader'];

        $user = $userReaderDAO->getRowById((int)$id);

        if(is_null($user)){
            $responseData['msg'] = 'Aucun adhérent ne correspond à votre demande';
        }else{
            $responseData['users'] = $user->toArray();
        }

        return new JsonResponse($responseData);

    }

    /**
     * Return list of user
     *
     * @param Application $app
     * @return JsonResponse
     */
    public function userListAction(Application $app)
    {
        /** @var UserReaderDAO $userReaderDAO */
        $userReaderDAO = $app['dao.user.reader'];

        $users = $userReaderDAO->getAll();

        $responseData = array();
        $aUsers = array();

        foreach($users as $user)
        {
            $aUsers[] = $user->toArray();
        }

        $responseData['nb'] = count($aUsers);

        if(empty($aUsers)){
            $responseData['msg']='Aucun adhérent ne correspond à votre demande';
        }else{
            $responseData['users'] = $aUsers;
        }

        return new JsonResponse($responseData);
    }

}