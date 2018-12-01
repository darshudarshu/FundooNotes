import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from '@angular/common/http';
import { serviceUrl } from '../serviceUrl/serviceUrl';
@Injectable({
  providedIn: 'root'
})
export class NoteserviceService {

  constructor(private http: HttpClient, private serviceurl: serviceUrl) { }
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
    return this.http.post(this.serviceurl.host + this.serviceurl.createNotes, notesData);
  }
  /**
    * @method noteUserData() 
    * @return observable data
    * @param email 
    * @description Function to send email to server
    */
  noteUserData(email) {

    let notesUserData = new FormData();
    notesUserData.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.userNotes, notesUserData)
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
    return this.http.post(this.serviceurl.host + this.serviceurl.changeColor, colorData)
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
    return this.http.post(this.serviceurl.host + this.serviceurl.changeDateTime, DataTime)
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
    return this.http.post(this.serviceurl.host + this.serviceurl.deleteNote, deleteNote)
  }
  /**
    * @method editedNoteData() 
    * @return observable data
    * @param email 
    * @param editedNotes 
    * @description Function to send email and editedNotes to server
    */
  editedNoteData(editedNotes, email) {
    let editedNotesData = new FormData();
    editedNotesData.append("id", editedNotes.id)
    editedNotesData.append("title", editedNotes.title)
    editedNotesData.append("notes", editedNotes.notes)
    editedNotesData.append("remainder", editedNotes.remainder)
    editedNotesData.append("color", editedNotes.color)
    editedNotesData.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.editedNotesData, editedNotesData);

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
    return this.http.post(this.serviceurl.host + this.serviceurl.noteLabel, noteLabel)
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
    return this.http.post(this.serviceurl.host + this.serviceurl.deleteNoteLabel, deleteNoteLabel)
  }
  /**
    * @method dragAndDrop() 
    * @return observable data
    * @param prevId
    * @param currId 
    * @description Function to drag and drop the card
    */
  dragAndDrop(diff, currId, direction, email) {
    let dragAndDropData = new FormData();
    dragAndDropData.append("diff", diff)
    dragAndDropData.append("currId", currId)
    dragAndDropData.append("direction", direction)
    dragAndDropData.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.dragAndDropData, dragAndDropData)
  }



}

