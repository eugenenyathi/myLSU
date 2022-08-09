<?php 

  interface ResetInterface{
    public function resetRequestsTable();
    public function resetRequestRoomTable();
    public function resetPreferredRoomMates();
    
    public function getRequestsTable();
    public function getRequestRoomTable();
    public function getPreferredRoomMates();
  }