<?
class callouts
{
    private $model;
    private $view;

    private $emailHistoryModel;
    private $currentCalloutId;

    function __construct()
    {
        $this->model = new calloutsModel();
        $this->view = new calloutsView($this->model);

        $this->emailHistoryModel = new emailHistoryModel();
    }

    function index()
    {
        $login_user = sess('user_id');
        $this->model->readAll("where callouts.callout_status_id = 2 AND callouts.technician_id = $login_user order by callout_time DESC Limit 40");
        $this->view->render('calloutsTable');

    }

    function open()
    {
        $login_user = sess('user_id');
        $this->model->readAll("where callouts.callout_status_id = 1 AND callouts.technician_id = $login_user order by callout_time DESC Limit 40");
        $this->view->render('openCalloutsTable');
    }

    function shutdown()
    {
        $login_user = sess('user_id');
        $this->model->readAll("where callouts.callout_status_id = 3 AND callouts.technician_id = $login_user order by callout_time DESC Limit 40");
        $this->view->render('shutdownCalloutsTable');
    }

    function followup()
    {
        $login_user = sess('user_id');
        $this->model->readAll("where callouts.callout_status_id = 4 order by callout_time DESC Limit 40");
        $this->view->render('followupTable');
    }


    function form()
    {
        $this->model->read(req('id'));
        $jobs = new jobs();

        if(req('job_id')){
            $jobs->model->read(req('job_id'));
            $this->model->notify_email = $jobs->model->job_email;
        }else{
            $jobs->model->read($this->model->job_id);
        }

        $login_user = sess('user_id');
        $users = mysqli_fetch_array(query("select * from technicians where technician_id = $login_user"));
        $user_email = $users['technician_email'];

        $data = array(
            "jobs"=>$jobs,
            "user_email"=>$user_email
        );
        $this->view->render('calloutsForm',$data);
    }


    function action()
    {
        $this->model->callout_id = req('callout_id');
        $this->model->is_printed = req('is_printed');
        $this->model->job_id = req('job_id');
        $this->model->fault_id = req('fault_id');
        $this->model->technician_id = sess('user_id');
        $this->model->technician_fault_id = req('technician_fault_id');
        $this->model->priority_id = req('priority_id');
        $this->model->callout_status_id = req('callout_status_id');
        $this->model->lift_ids = getChecked('lift_id');
        $this->model->floor_no = req('floor_no');
        $this->model->callout_description = req('callout_description');
        $this->model->correction_id = req('correction_id');
        $this->model->attributable_id = 1;
        $this->model->tech_description = req('tech_description');
        $this->model->order_number = req('order_number');
        $this->model->docket_number = req('docket_number');
        $this->model->contact_details = req('contact_details');
        $this->model->callout_time = strtotime(req('callout_time'));
        $this->model->time_of_arrival = strtotime(req('time_of_arrival'));
        $this->model->time_of_departure = strtotime(req('time_of_departure'));
        $this->model->chargeable_id = req('chargeable_id');
        $this->model->technician_signature = req('technician_signature');
        $this->model->customer_signature = req('customer_signature');
        $this->model->accepted_id = req('accepted_id');
        $this->model->updated = req('updated');
        $this->model->user_id = req('user_id');
        $this->model->notify_email = req('notify_email');
        $this->model->reported_customer = req('reported_customer');
        $this->model->rectification_time = strtotime(req('rectification_time'));
        $this->model->part_description = req('part_description');
        $this->model->photo_name = $_FILES['file']['name'];



        $name = $_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];
        $location = 'public/uploads/';
        move_uploaded_file($tmp_name, $location.$name);


        $jobs = new jobs();
        $jobs->model->read(req('job_id'));

        $_faults = new _faults();
        $_faults->model->read($this->model->fault_id);

        $_technician_faults = new _technician_faults();
        $_technician_faults->model->read($this->model->technician_fault_id);

        $_corrections = new _corrections();
        $_corrections->model->read($this->model->correction_id);

        $_attributable = new _attributable();
        $_attributable->model->read($this->model->attributable_id);

        $chargeable_id = $this->model->chargeable_id;
        $chargeable = mysqli_fetch_array(query("select * from _chargeable where chargeable_id = $chargeable_id"));

        // $users = new users();
        $user_id = $this->model->technician_id;
        $user =  mysqli_fetch_array(query("select * from users where user_id = $user_id"));

        if(req('callout_id'))
        {
            $this->currentCalloutId = req('callout_id');
            $this->model->update();
            $data = array(
                "jobs"=>$jobs,
                "faults"=>$_faults,
                "technician_faults"=>$_technician_faults,
                "correction"=>$_corrections,
                "chargeable"=>$chargeable,
                "user"=>$user,
                "callout_id"=>$this->currentCalloutId
            );
            $this->view->renderPdf('calloutsPrint',$data);
            sess('alert','Callout Updated');
            redirect(URL.'/callouts/form/'.req('callout_id'));
        }else{
            $this->currentCalloutId = $this->model->create();
            $data = array(
                "jobs"=>$jobs,
                "faults"=>$_faults,
                "technician_faults"=>$_technician_faults,
                "correction"=>$_corrections,
                "chargeable"=>$chargeable,
                "user"=>$user,
                "callout_id"=>$this->currentCalloutId
            );

            $this->view->renderPdf('calloutsPrint',$data);
            sess('alert','Callout Created');
            redirect(URL."/callouts/");
        }

        sendNotification($this->currentCalloutId, $this->model, $jobs, $_faults, $_technician_faults, $_corrections, $_attributable);

    }

    function delete()
    {
        $this->model->delete(req('id'));
        sess('alert','Callout Deleted');
        redirect(URL.'/callouts');
    }
}
?>
