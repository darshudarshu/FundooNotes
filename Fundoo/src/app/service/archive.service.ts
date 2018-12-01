import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from '@angular/common/http';
import { serviceUrl } from '../serviceUrl/serviceUrl';
@Injectable({
  providedIn: 'root'
})
export class ArchiveService {
  
constructor(private http: HttpClient, private serviceurl: serviceUrl ) { }
  /**
    * @method archiveThisNote() 
    * @return observable data
    * @param email 
    * @param id 
    * @description Function to send email and id to server
    */
  archiveThisNote(id, email) {
    let archiveNote = new FormData();
    archiveNote.append("id", id)
    archiveNote.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.archiveNote, archiveNote)
  }
  /**
    * @method fetchArchiveNote() 
    * @return observable data
    * @param email 
    * @description Function to send email to server
    */
  fetchArchiveNote(email) {
    let ArchiveNote = new FormData();
    ArchiveNote.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.fetchArchiveNote, ArchiveNote)
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
    return this.http.post(this.serviceurl.host + this.serviceurl.fetchUnArchiveNote , unArchiveNote)
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
    return this.http.post(this.serviceurl.host + this.serviceurl.deleteArchiveNote, deleteArchiveNote)
  }
}
