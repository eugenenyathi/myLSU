<?php 

  interface RMResponseInterface{
    public function setResponse($currentSessionStudentId, $res);
    public function setRecordRequest($currentSessionStudentId);
    public function deleteRoomMateAssoc($currentSessionStudentId);
  }