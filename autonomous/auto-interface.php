<?php 

  interface AutoInterface {
    public function getRequestRoomStatus($studentId);
    public function setConfirmStatus($studentId, $value);
    public function deleteMainRequest($studentId);
    public function deleteRequest($studentId);
  }

 ?>