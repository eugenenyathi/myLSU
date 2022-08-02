<?php 

  interface ViewInterface {
    public function getRequestRoomStatus($studentId); 
    public function getRoomMateStatus($studentId);
    public function getRoomRequestDate($studentId);
    public function getRoomMates($studentId);
    public function getRequestStudentId($studentId);
    public function getStudentDetails($studentId);
    public function getMyRoomMates($requestRoomMateId, $studentId);
    public function getRequestRoomMateData($requestRoomMateId);
  }