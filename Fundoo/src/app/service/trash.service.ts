import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from '@angular/common/http';
import { serviceUrl } from '../serviceUrl/serviceUrl';
@Injectable({
  providedIn: 'root'
})
export class TrashService {

  constructor(private http: HttpClient, private serviceurl: serviceUrl) { }
  /**
    * @method restoreTrashNote() 
    * @return observable data
    * @param email 
    * @param id   
    * @description Function to send email and id to server
    */
  restoreTrashNote(id, email) {
    let restoreTrashNote = new FormData();
    restoreTrashNote.append("id", id)
    restoreTrashNote.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.trashRestoreDeletedNote, restoreTrashNote)
  }
  /**
    * @method fetchTrashNote() 
    * @return observable data
    * @param email 
    * @description Function to send email and id to server
    */
  fetchTrashNote(email) {
    let TrashNote = new FormData();
    TrashNote.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.trashFetchTrashNote, TrashNote)
  }
  /**
    * @method deletTrashNote() 
    * @return observable data
    * @param email 
    * @param id 
    * @description Function to send email and id to server
    */
  deletTrashNote(id, email) {
    let deleteNote = new FormData();
    deleteNote.append("id", id)
    deleteNote.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.trashFetchDeleteNote, deleteNote)
  }

}
