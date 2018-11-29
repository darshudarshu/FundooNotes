import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class TrashService {
  /**
    * Api urls
    */
  private urlRestoreDeletedNote = "http://localhost/codeigniter/restoreDeletedNote";
  private urlFetchTrashNote = "http://localhost/codeigniter/fetchTrashNote";
  private urlFetchDeleteNote = "http://localhost/codeigniter/deleteTrashNote";
  constructor(private http: HttpClient) { }
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
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlRestoreDeletedNote, restoreTrashNote, otheroption)
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
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlFetchTrashNote, TrashNote, otheroption)
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
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlFetchDeleteNote, deleteNote, otheroption)
  }

}
