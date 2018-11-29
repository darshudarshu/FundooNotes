import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class CollabaratorService {
  /**
    * Api urls
    */
  private urlAddCollabarator = "http://localhost/codeigniter/addCollabarator";
  private urlFetchCollabarators = "http://localhost/codeigniter/fetchCollabarators";
  private urlFetchOwner = "http://localhost/codeigniter/fetchOwner";
  private urlDeleteCollabaratorData = "http://localhost/codeigniter/deleteCollabaratorData";
  private urlDeleteMainCollabaratorData = "http://localhost/codeigniter/deleteMainCollabaratorData";
  private urlCollabaratorsOfNotes = "http://localhost/codeigniter/collabaratorsOfNotes";
  private urlDeleteAllMainCollabaratorData = "http://localhost/codeigniter/deleteAllMainCollabaratorData";
  constructor(private http: HttpClient) { }
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
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlAddCollabarator, collabaratorData, otheroption)
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
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlFetchCollabarators, idCollabaratorData, otheroption)
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
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlFetchOwner, idOwner, otheroption)
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
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlDeleteCollabaratorData, deleteData, otheroption)
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
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlCollabaratorsOfNotes, CollabaratorsOfNotes, otheroption)
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
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlDeleteMainCollabaratorData, deleteMainData, otheroption)
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
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlDeleteAllMainCollabaratorData, deleteAllMainData, otheroption)
  }
}
