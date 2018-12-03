export interface Notes {
  id: string;
  email: string;
  title: string;
  notes: string;
  remainder: string;
  color: string;
  isArchive: string;
  isDeleted: string;
  label: string;
  dragId: ByteString;
  image: string;
}

export interface Labels {
  id: string;
  email: string;
  name: string;
}

export interface Collaborators {
  id: string;
  noteId: string;
  owner: string;
  email: string;
}
export interface Registration {
  id: string;
  username: string;
  mobilenumber: string;
  email: string;
  password: string;
  reset_key: string;
  active: string;
  profilepic: string;
}
