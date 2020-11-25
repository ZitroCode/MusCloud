<?php

class Song {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getSongs() {
        $this->db->query("SELECT * FROM songs");
        return $this->db->resultsGet();
    }

    public function addSong($data) {
        $this->db->query("INSERT INTO songs (Name, Artists, Url, Cover, Created_date) 
        VALUES (:name, :artists, :song, :cover, :date)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':artists', $data['artist']);
        $this->db->bind(':song', $data['audio']);
        $this->db->bind(':cover', $data['cover']);
        $this->db->bind(':date', date("Y-m-d H:i:s"));
        
        return ($this->db->run()) ? true : false; 
    }

    public function deleteSong($id) {
        $this->db->query("DELETE FROM songs WHERE Id=:id");
        $this->db->bind(':id', $id);
        return ($this->db->run()) ? true : false;
    }

    public function updateSong($id, $name, $artist) {
        $this->db->query("UPDATE songs SET Name=:name, Artists=:artist WHERE Id=:id");
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $name);
        $this->db->bind(':artist', $artist);
        return ($this->db->run()) ? true : false;
    }
}