<?php


namespace WebService\Tests;


use Silex\WebTestCase;

class AppTest extends WebTestCase{

    public function testAppelAvecIdentifiantConnu()
    {
        $data = '{"users":{"id":"1","nom":"Bland","prenom":" Angie","telephone":"0611111111"}}';


        $client = $this->createClient();
        $client->request('GET', '/api/user/1');

        $reponse = $client->getResponse()->getContent();

        $this->assertEquals($data, $reponse);
    }


    public function testAppelAvecIdentifiantUnConnu()
    {
        $data = '{"msg":"Aucun adh\u00e9rent ne correspond \u00e0 votre demande"}';

        $client = $this->createClient();
        $client->request('GET', '/api/user/5');

        $reponse = $client->getResponse()->getContent();

        $this->assertEquals($data, $reponse);
    }

    public function testListAdherent()
    {
        $data = '{"nb":5,"users":[{"id":"1","nom":"Bland","prenom":" Angie","telephone":"0611111111"},'.
        '{"id":"2","nom":"Dole\u017ealov\u00e1 ","prenom":" Michaela","telephone":"0622222222"},'.
        '{"id":"3","nom":"Williams  ","prenom":" Sherri ","telephone":"0633333333"},'.
        '{"id":"4","nom":"Koutoux\u00eddou","prenom":" Nikol\u00e9tta ","telephone":"0644444444"},'.
        '{"id":"6","nom":"Vandesteene ","prenom":" Els","telephone":"0655555555"}]}';


        $client = $this->createClient();
        $client->request('GET', '/api/users');

        $reponse = $client->getResponse()->getContent();

        $this->assertEquals($data, $reponse);
    }

    public function testListAdherentVide()
    {
        $this->reloadUserTable('usersEmpty.csv');

        $data = '{"nb":0,"msg":"Aucun adh\u00e9rent ne correspond \u00e0 votre demande"}';

        $client = $this->createClient();
        $client->request('GET', '/api/users');

        $reponse = $client->getResponse()->getContent();

        $this->assertEquals($data, $reponse);

    }

    public function testUserFileNotFound()
    {
        $this->reloadUserTable('user.csv');

        $data = '{"code":404,"msg":"Le fichier d\u2019entr\u00e9e est introuvable"}';

        $client = $this->createClient();
        $client->request('GET', '/api/users');

        $reponse = $client->getResponse()->getContent();

        $this->assertEquals($data, $reponse);
    }


    private function reloadUserTable($file)
    {

        $this->app['dao.user.reader'] = $this->app->share(function ($app) use ($file) {
            $userTable = __DIR__.'/../../db/'.$file;
            if(!file_exists($userTable)){
                $this->app->abort(404, "Le fichier d’entrée est introuvable");
            }

            $userReaderDAO = new \WebService\DAO\UserReaderDAO($userTable);

            return $userReaderDAO;
        });
    }



    /**
     * {@inheritDoc}
     */
    public function createApplication()
    {
        $app = new \Silex\Application();

        require __DIR__.'/../../app/config/dev.php';
        require __DIR__.'/../../app/app.php';
        require __DIR__.'/../../app/routes.php';

        // Generate raw exceptions instead of HTML pages if errors occur
        $app['exception_handler']->disable();
        // Simulate sessions for testing
        $app['session.test'] = true;
        // Enable anonymous access to admin zone
        $app['security.access_rules'] = array();

        return $app;
    }

}
