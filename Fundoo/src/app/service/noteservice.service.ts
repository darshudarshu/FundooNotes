import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class NoteserviceService {
  /**
    * Api urls
    */
  private urlCreateNotes = "http://localhost/codeigniter/createNotes";
  private urlUserNotes = "http://localhost/codeigniter/userNotes";
  private urlchangeColor = "http://localhost/codeigniter/changeColor";
  private urlchangeDateTime = "http://localhost/codeigniter/changeDateTime";
  private urlDeleteNote = "http://localhost/codeigniter/deleteNote";
  private urlEditedNotesData = "http://localhost/codeigniter/editNotes";
  private urlNoteLabel = "http://localhost/codeigniter/noteLabel";
  private urlDeleteNoteLabel = "http://localhost/codeigniter/deleteNoteLabel";
  private urlDragAndDropData = "http://localhost/codeigniter/dragDrop";


  constructor(private http: HttpClient) { }
  /**
    * @method noteData() 
    * @return void
    * @param notes
    * @param email 
    * @param currentDateTime
    * @param color
    * @param isArchive        
    * @param labelname
    * @param isHaveCollabarator
    * @return observable data
    * @description Function to send note data to server
    */
  noteData(notes, email, currentDateTime, color, isArchive, labelname, isHaveCollabarator) {
    let notesData = new FormData();
    notesData.append("email", email)
    notesData.append("title", notes.title)
    notesData.append("notes", notes.note)
    notesData.append("remainder", currentDateTime)
    notesData.append("color", color)
    notesData.append("isArchive", isArchive)
    notesData.append("label", labelname)
    notesData.append("isHaveCollabarator", isHaveCollabarator)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlCreateNotes, notesData, otheroption);
  }
  /**
    * @method noteUserData() 
    * @return observable data
    * @param email 
    * @description Function to send email to server
    */
  noteUserData(email) {
    ;
    let notesUserData = new FormData();
    notesUserData.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlUserNotes, notesUserData, otheroption)
  }
  /**
    * @method colorChange() 
    * @return observable data
    * @param email 
    * @param id 
    * @description Function to send email and id to server
    */
  colorChange(id, color) {
    let colorData = new FormData();
    colorData.append("id", id)
    colorData.append("color", color)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlchangeColor, colorData, otheroption)
  }
  /**
    * @method dateTimeChange() 
    * @return observable data
    * @param otherPresentTime 
    * @param id 
    * @description Function to send otherPresentTime and id to server
    */
  dateTimeChange(id, otherPresentTime) {
    let DataTime = new FormData();
    DataTime.append("id", id)
    DataTime.append("presentDateTime", otherPresentTime)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlchangeDateTime, DataTime, otheroption)
  }
  /**
    * @method deleteThisNote() 
    * @return observable data
    * @param email 
    * @param id 
    * @description Function to send email and id to server
    */
  deleteThisNote(id, email) {
    let deleteNote = new FormData();
    deleteNote.append("id", id)
    deleteNote.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlDeleteNote, deleteNote, otheroption)
  }
  /**
    * @method editedNoteData() 
    * @return observable data
    * @param email 
    * @param editedNotes 
    * @description Function to send email and editedNotes to server
    */
  editedNoteData(editedNotes, email) {
    ;
    let editedNotesData = new FormData();
    editedNotesData.append("id", editedNotes.id)
    editedNotesData.append("title", editedNotes.title)
    editedNotesData.append("notes", editedNotes.notes)
    editedNotesData.append("remainder", editedNotes.remainder)
    editedNotesData.append("color", editedNotes.color)
    editedNotesData.append("email", email)

    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlEditedNotesData, editedNotesData, otheroption);

  }
  /**
    * @method setLabels() 
    * @return observable data
    * @param label 
    * @param id 
    * @description Function to send label and id to server
    */
  setLabels(id, label) {
    let noteLabel = new FormData();
    noteLabel.append("id", id)
    noteLabel.append("label", label)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlNoteLabel, noteLabel, otheroption)
  }
  /**
    * @method deleteLabels() 
    * @return observable data
    * @param id 
    * @description Function to send id to server
    */
  deleteLabels(id) {
    let deleteNoteLabel = new FormData();
    deleteNoteLabel.append("id", id)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlDeleteNoteLabel, deleteNoteLabel, otheroption)
  }
  /**
    * @method dragAndDrop() 
    * @return observable data
    * @param prevId
    * @param currId 
    * @description Function to drag and drop the card
    */
  dragAndDrop(diff , currId , direction,email) {
    let dragAndDropData = new FormData();
    dragAndDropData.append("diff", diff)
    dragAndDropData.append("currId", currId)
    dragAndDropData.append("direction", direction)
    dragAndDropData.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlDragAndDropData, dragAndDropData, otheroption)
  }



}

