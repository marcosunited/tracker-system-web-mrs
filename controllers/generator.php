<?
    class gen
    {
        function index()
        {
            $data = array(
                'tables'=>db::query('show tables')
            );
            
            $view=new view(null);
            $view->render('generatorForm',$data);
        }
        
        function action()
        {
            $table = req('table');
            genFiles($table);
            sess('alert','Files Generated');
            redirect(URL.'/gen/');
        }
    }
?>