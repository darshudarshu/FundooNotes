import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ArchiveService {
  /**
    * Api urls
    */
  private urlArchiveNote = "http://localhost/codeigniter/archiveNote";
  private urlFetchArchiveNote = "http://localhost/codeigniter/fetchArchiveNote";
  private urlFetchUnArchiveNote = "http://localhost/codeigniter/fetchUnArchiveNote";
  private urlDeleteArchiveNote = "http://localhost/codeigniter/deleteArchiveNote";
  constructor(private http: HttpClient) { }
  /**
    * @method archiveThisNote() 
    * @return observable data
    * @param email 
    * @param id 
    * @description Function to send email and id to server
    */
  archiveThisNote(id, email) {
    ;
    let archiveNote = new FormData();
    archiveNote.append("id", id)
    archiveNote.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlArchiveNote, archiveNote, otheroption)
  }
  /**
    * @method fetchArchiveNote() 
    * @return observable data
    * @param email 
    * @description Function to send email to server
    */
  fetchArchiveNote(email) {
    ;
    let ArchiveNote = new FormData();
    ArchiveNote.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlFetchArchiveNote, ArchiveNote, otheroption)
  }
  /**
    * @method unArchiveThisNote() 
    * @return observable data
    * @param email 
    * @param id 
    * @description Function to send email and id to server
    */
  unArchiveThisNote(id, email) {
    let unArchiveNote = new FormData();
    unArchiveNote.append("id", id)
    unArchiveNote.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlFetchUnArchiveNote, unArchiveNote, otheroption)
  }
  /**
    * @method deleteArchiveNote() 
    * @return observable data
    * @param email 
    * @param id 
    * @description Function to send email and id to server
    */
  deleteArchiveNote(id, email) {
    let deleteArchiveNote = new FormData();
    deleteArchiveNote.append("id", id)
    deleteArchiveNote.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlDeleteArchiveNote, deleteArchiveNote, otheroption)
  }
}
