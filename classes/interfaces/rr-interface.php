<?php
  
  interface RequestRoomInterface{
    public function registerRequest($requestingStudentId);
    public function registerPreferredRoomMates($requestingStudentId, $selectedRoomMates);
    public function setRecordRequest($requestingStudentId);
    public function deleteRegisteredRequest($requestingStudentId);
    public function getPreferredNumOfRoomMates($requestingStudentId);
    public function getRequestRoomStatus($requestingStudentId);
  }
  
