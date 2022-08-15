<?php 

  interface AllocateRoomInterface {
    public function getRequests($level);
    public function getAllRequests($level);
    public function getRequestProcessMarker($studentId);
    public function getRoomMates($requestStudentId, $limit);
    public function getRoomMate($requestStudentId);
    public function deleteRoomMates($requestStudentId);
    public function getAuditRequestMarker($studentId);
    public function getStudentRoomAllocStatus($studentId);
    public function setStudentRoomAllocStatus($studentId, $marker);
    public function getCountRoomOccupants($roomNo);
    public function getAuditRooms();
    public function setNewRoomOccupant($roomNo, $studentId);
    public function getRoomMateConfirmStatus($requestStudentId);
    public function setGrantRoomRequest($requestStudentId, $roomNumber);
    public function setGrantRoom($roomNumber, $studentId);
    public function setRoomAvaiStatus($roomNumber);
    public function setRequestProcessed($requestStudentId, $marker);
    public function getNegativeStatus($requestStudentId);
    public function getNegativeProcessMarker($level);
    public function getCountPositiveStatus($requestStudentId);
    public function getSetStatus($studentId, $level);
  };