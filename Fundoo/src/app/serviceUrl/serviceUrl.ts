import { environment } from "../../environments/environment";
export class serviceUrl {


  public host = environment.baseURL;
  public createNotes = "createNotes";
  public userNotes = "userNotes";
  public changeColor = "changeColor";
  public changeDateTime = "changeDateTime";
  public deleteNote = "deleteNote";
  public editedNotesData = "editNotes";
  public noteLabel = "noteLabel";
  public deleteNoteLabel = "deleteNoteLabel";
  public dragAndDropData = "dragDrop";

  public remainderFetchRemainderNote = "fetchRemainderNote";
  public remainderchangeDateTime = "changeRemainderDateTime";
  public remainderCreateRemainderNotes = "createRemainderNotes";
  public remainderDeleteRemainderNote = "deleteRemainderNote";

  public trashRestoreDeletedNote = "restoreDeletedNote";
  public trashFetchTrashNote = "fetchTrashNote";
  public trashFetchDeleteNote = "deleteTrashNote";

  public labelFetchLabelNote = "fetchLabelNote";
  public labelChangeLabelDateTime = "changeLabelDateTime";
  public labelCreateLabelNotes = "createLabelNotes";
  public labelDeleteLabelNote = "deleteLabelNote";
  public labelDeleteNoteLabel = "deleteNoteLabels";

  public mainLabelLabelData = "addLabel";
  public mainLabelFetchLabelData = "saveLabels";
  public mainLabelChangeLabel = "changeLabel";
  public mainLabelDeleteLabel = "deleteLabel";


  public archiveNote = "archiveNote";
  public fetchArchiveNote = "fetchArchiveNote";
  public fetchUnArchiveNote = "fetchUnArchiveNote";
  public deleteArchiveNote = "deleteArchiveNote";

  public addCollabarator = "addCollabarator";
  public fetchCollabarators = "fetchCollabarators";
  public fetchOwner = "fetchOwner";
  public deleteCollabaratorData = "deleteCollabaratorData";
  public deleteMainCollabaratorData = "deleteMainCollabaratorData";
  public collabaratorsOfNotes = "collabaratorsOfNotes";
  public deleteAllMainCollabaratorData = "deleteAllMainCollabaratorData";

  public register = "registration";
  public login = "login";
  public forgot = "forgotPassword";
  public reset = "resetPassword";
  public getEmail = "getEmailId";
  public verifyEmail = "veryfyEmailId";

  public profileFetchImage = "fetchImage";
  public profileSaveImage = "saveImage";
  public notesSaveImage = "noteSaveImage";
  
  public socialLoginData = "socialSignIn";
  public notesFetchImage ="notesFetchImage";
}
