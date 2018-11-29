import { AuthGuard } from './auth.guard';
import { NgModule } from "@angular/core";
import { Routes, RouterModule } from "@angular/router";
import { ForgotComponent } from "./forgot/forgot.component";
import { LoginComponent } from "./login/login.component";
import { ResetComponent } from "./reset/reset.component";
import { RegisterComponent } from "./register/register.component";
import { VerifyComponent } from './verify/verify.component';
import { FundooNotesComponent } from './fundoo-notes/fundoo-notes.component';
import { NotesComponent } from './notes/notes.component';
import { SetremainderComponent } from './setremainder/setremainder.component';
import { TrashComponent } from './trash/trash.component';
import { EditnotesComponent } from './editnotes/editnotes.component';
import { LabelsComponent } from './labels/labels.component';
import { ArchiveComponent } from './archive/archive.component';
import { LabelcomponentComponent } from './labelcomponent/labelcomponent.component';
import { CollabaratorComponent } from './collabarator/collabarator.component';
import { CreatecollabaratorComponent } from './createcollabarator/createcollabarator.component';

const routes: Routes = [
  { path: "", redirectTo: 'login', pathMatch: "full" },
  { path: "login", component: LoginComponent },
  {
    path: 'fundoo', component: FundooNotesComponent,
    canActivate: [AuthGuard],
    children: [
      { path: '', redirectTo: 'notes', pathMatch: 'full' },
      {
        path: "remainder", component: SetremainderComponent,
        canActivate: [AuthGuard]
      },
      {
        path: "trash", component: TrashComponent,
        canActivate: [AuthGuard]
      },
      {
        path: "labelcomp", component: LabelcomponentComponent,
        canActivate: [AuthGuard]
      },
      {
        path: "createcollacomp", component: CreatecollabaratorComponent,
        canActivate: [AuthGuard]
      },
      {
        path: "collacomp", component: CollabaratorComponent,
        canActivate: [AuthGuard]
      },
      {
        path: "archive", component: ArchiveComponent,
        canActivate: [AuthGuard]
      },
      {
        path: "notes", component: NotesComponent,
        canActivate: [AuthGuard],

        children: [
          {
            path: "labelcomp", component: LabelcomponentComponent,
            canActivate: [AuthGuard]
          }
        ]
      }
    ]
  },
  { path: "labels", component: LabelsComponent },
  { path: "edit", component: EditnotesComponent },
  { path: "register", component: RegisterComponent },
  { path: "forgot", component: ForgotComponent },
  { path: "reset", component: ResetComponent },
  { path: "verify", component: VerifyComponent }
]

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
