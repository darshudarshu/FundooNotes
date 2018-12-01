import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from '@angular/common/http';
import { serviceUrl } from '../serviceUrl/serviceUrl';
@Injectable({
  providedIn: 'root'
})
export class CollabaratorService {
  
  constructor(private http: HttpClient, private serviceurl: serviceUrl) { }
  /**
    * @method addCollabarators() 
    * @return observable data
    * @param email 
    * @param id 
    * @param collabratorEmail     
    * Function to send email and id to server
    */
  addCollabarators(id, email, collabratorEmail) {
    let collabaratorData = new FormData();
    collabaratorData.append("id", id)
    collabaratorData.append("email", email)
    collabaratorData.append("collabratorEmail", collabratorEmail)
    return this.http.post(this.serviceurl.host + this.serviceurl.addCollabarator, collabaratorData)
  }
  /**
    * @method fetchCollabarators() 
    * @return observable data
    * @param email 
    * @param id 
    * Function to send email and id to server
    */
  fetchCollabarators(id, email) {
    let idCollabaratorData = new FormData();
    idCollabaratorData.append("id", id)
    idCollabaratorData.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.fetchCollabarators, idCollabaratorData)
  }
  /**
    * @method fetchOwner() 
    * @return observable data
    * @param id 
    * @description Function to send email  to server
    */
  fetchOwner(id) {
    let idOwner = new FormData();
    idOwner.append("id", id)
    return this.http.post(this.serviceurl.host + this.serviceurl.fetchOwner, idOwner)
  }
  /**
    * @method deleteCollabarators() 
    * @return observable data
    * @param email 
    * @param collId 
    * @param NoteId
    * @param currentEmail
    * @description Function to send email and id  collId  currentEmail to server
    */
  deleteCollabarators(collId, email, currentEmail, noteId) {

    let deleteData = new FormData();
    deleteData.append("collId", collId)
    deleteData.append("noteId", noteId)
    deleteData.append("email", email)
    deleteData.append("currentEmail", currentEmail)
    return this.http.post(this.serviceurl.host + this.serviceurl.deleteCollabaratorData, deleteData)
  }
  /**
    * @method fetchCollabaratorsOfNotes() 
    * @return observable data
    * @param email 
    * @description Function to send email to server
    */
  fetchCollabaratorsOfNotes(email) {
    let CollabaratorsOfNotes = new FormData();
    CollabaratorsOfNotes.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.collabaratorsOfNotes, CollabaratorsOfNotes)
  }
  /**
    * @method deleteMainCollabarators() 
    * @return observable data
    * @param email 
    * @param NoteId
    * @param currentEmail
    * @description Function to send email,currentEmail and noted to server
    */

  deleteMainCollabarators(noteId, email, currentEmail) {
    let deleteMainData = new FormData();

    deleteMainData.append("noteId", noteId)
    deleteMainData.append("email", email)
    deleteMainData.append("currentEmail", currentEmail)
    return this.http.post(this.serviceurl.host + this.serviceurl.deleteMainCollabaratorData, deleteMainData)
  }
  /**
    * @method deleteAllMainCollabarators() 
    * @return observable data
    * @param email 
    * @param NoteId 
    * @description Function to send email and NoteId to server
    */
  deleteAllMainCollabarators(noteId, email) {
    let deleteAllMainData = new FormData();

    deleteAllMainData.append("noteId", noteId)
    deleteAllMainData.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.deleteAllMainCollabaratorData, deleteAllMainData)
  }
}
