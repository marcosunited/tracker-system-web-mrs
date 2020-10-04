<?
class emailHistoryModel
{
    public $id;
    public $email_from;
    public $email_to;
    public $subject;
    public $date_sent;
    public $date_created;
    public $status;
    public $user_id;
    public $item_id;
    public $item_type_id;
    public $attempt;
    public $include_attachment;
    public $exception_message;


function create()
    {

        return db::query("INSERT INTO email_history ( id,
                                                            email_from,
                                                            email_to,
                                                            subject,
                                                            date_sent,
                                                            date_created,
                                                            status,
                                                            user_id,
                                                            item_id,
                                                            item_type_id,
                                                            attempt,
                                                            include_attachment,
                                                            exception_message) VALUES (
                                                            0$this->id,
                                                            '$this->email_from',
                                                            '$this->email_to',
                                                            '$this->subject',
                                                            0$this->date_sent,
                                                            0$this->date_created,
                                                            '$this->status',
                                                            0$this->user_id,
                                                            0$this->item_id,
                                                            0$this->item_type_id,
                                                            0$this->attempt,
                                                            0$this->include_attachment,
                                                            '$this->exception_message');");
    }

    function read($id)
    {
        $email_history = db::query("select * from email_history where email_history_id = $id");

        if($email_history){
            $email_history = $email_history[0];
            $this->$id = $email_history['id'];
            $this->email_from = $email_history['email_from'];
            $this->email_to = $email_history['email_to'];
            $this->subject = $email_history['subject'];
            $this->date_sent = $email_history['date_sent'];
            $this->date_created = $email_history['date_created'];
            $this->status = $email_history['status'];
            $this->user_id = $email_history['user_id'];
            $this->item_id = $email_history['item_id'];
            $this->item_type_id = $email_history['item_type_id'];
            $this->attempt = $email_history['attempt'];
            $this->include_attachment = $email_history['include_attachment'];
            $this->exception_message = $email_history['exception_message'];
            return true;
        }

        return false;
    }

    function update()
    {
        $query = "UPDATE email_history SET
                      id = 0$this->id,        
                      email_from = '$this->email_from',        
                      email_to = '$this->email_to',        
                      subject = '$this->subject',        
                      date_sent = 0$this->date_sent,        
                      date_created = 0$this->date_created        
                      status = '$this->status',        
                      user_id = 0$this->user_id,        
                      item_id = 0$this->item_id,        
                      item_type_id = 0$this->item_type_id,
                      attempt = 0$this->attempt,
                      include_attachment = '$this->include_attachment',
                      exeption_message = '$this->exception_message'             
                      WHERE email_history_id = $this->email_history_id
            ";
        return db::query($query);
    }


    function readAll()
    {
        $this->list = db::query("select * from email_history $where");
    }

    function getNextAttempt($item_id){
/*        $query = "SELECT MAX(eh.attempt) + 1 AS next_attempt FROM email_history eh
                    WHERE eh.item_id = " . $item_id . " GROUP BY eh.attempt";*/
        $query = "select max(attempt) as attempt from email_history where item_id = " . $item_id;

        $queryResponse = db::query($query);
        if($queryResponse){
            $queryResponse = $queryResponse[0];
            return $queryResponse['attempt'] + 1;
        }
        return 1;
    }

    function getMaxAttempts(){
        $settingsQuery = "SELECT * FROM SETTINGS WHERE CODE = 'mail_attempts'";
        $settingsQueryResponse = db::query($settingsQuery);
        if($settingsQueryResponse){
            $settingsQueryResponse = $settingsQueryResponse[0];
            return $settingsQueryResponse['value'];
        }
        return 3;
    }
}
?>
