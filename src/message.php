<?php
class Message
{
    private $errmessage = array();
    private $successmessage = array();
    private $errMsgcounter = 0;
    private $successMsgcounter = 0;
    private $type;


    public function pushErrorMsg($msg)
    {
        $this->errmessage[] = $msg;
        $this->errMsgcounter++;
    }

    public function pushSuccessMsg($msg)
    {
        $this->successmessage[] = $msg;
        $this->successMsgcounter++;
    }

    public function getErrMsgCount()
    {
        return $this->errMsgcounter;
    }

    public function getSuccessMsgCount()
    {
        return $this->successMsgcounter;
    }

    public function printMessage()
    {
        if ($this->getErrMsgCount() == 0 && $this->getSuccessMsgCount() > 0) {
            $this->type  = 'success';
        } else if ($this->getErrMsgCount() > 0 && $this->getSuccessMsgCount() > 0) {
            $this->type  = 'success-err';
        } else if ($this->getErrMsgCount() == 0 && $this->getSuccessMsgCount() == 0) {
            $this->type  = 'no-changes';
        } else {
            $this->type  = 'err';
        }
        return array(
            'type' => $this->type,
            'errorMsgcounts' => $this->errMsgcounter,
            'errorMessage' => $this->errmessage,
            'successMsgcounts' => $this->successMsgcounter,
            'successMessage' => $this->successmessage
        );
    }

    public function printJsonMsg()
    {
        echo json_encode($this->printMessage());
    }
}

/* Documentation of Use */

// $msg=new Message();
// $msg->pushSuccessMsg("xyz");
// $msg->pushErrorMsg("abc");
// $msg->printJsonMsg();
