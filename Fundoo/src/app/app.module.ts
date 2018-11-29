import { BrowserModule } from "@angular/platform-browser";
import { NgModule } from "@angular/core";
import { AppRoutingModule } from "./app-routing.module";
import { AppComponent } from "./app.component";
import { LoginComponent } from "./login/login.component";
import { RegisterComponent } from "./register/register.component";
import { BrowserAnimationsModule } from "@angular/platform-browser/animations";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { ForgotComponent } from "./forgot/forgot.component";
import { HttpClientModule, HTTP_INTERCEPTORS } from "@angular/common/http";
import { ResetComponent } from "./reset/reset.component";
import { RouterModule } from "@angular/router";
import { DataService } from "./service/data.service";
import { LabelService } from "./service/label.service";
import { CommonService } from './service/common.service';
import { NoteserviceService } from "./service/noteservice.service";
import { NgxSpinnerModule } from 'ngx-spinner';
import { VerifyComponent } from './verify/verify.component';
import { HeaderComponent } from './header/header.component';
import { FundooNotesComponent } from './fundoo-notes/fundoo-notes.component';
import { LayoutModule } from '@angular/cdk/layout';
import { MatToolbarModule, MatSidenavModule, MatExpansionModule, MatDatepickerModule, MatGridListModule, MatMenuModule, MatTooltipModule, MatListModule, MatProgressSpinnerModule, MatIconModule, MatButtonModule, MatNativeDateModule, MatFormFieldModule, MatAutocompleteModule, MatCardModule, MatInputModule } from '@angular/material';
import { NotesComponent } from './notes/notes.component';
import { CookieService } from "angular2-cookie/services/cookies.service";
import { NgxMaterialTimepickerModule } from 'ngx-material-timepicker';
import { FlexLayoutModule } from '@angular/flex-layout';
import { SetremainderComponent } from './setremainder/setremainder.component';
import { AuthGuard } from "./auth.guard";
import { InterceptorsService } from "./service/interceptors.service";
import { EditnotesComponent } from './editnotes/editnotes.component';
import { MatDialogModule } from '@angular/material/dialog';
import { LabelsComponent } from './labels/labels.component';
import { MatSelectModule } from '@angular/material/select';
import { TrashComponent } from './trash/trash.component';
import { ArchiveComponent } from './archive/archive.component';
import { SelectlabelService } from "./service/selectlabel.service";
import { ArchiveService } from "./service/archive.service";
import { RemainderService } from "./service/remainder.service";
import { CollabaratorService } from "./service/collabarator.service";
import { TrashService } from "./service/trash.service";
import { CommonlabelService } from "./service/commonlabel.service";
import { LabelcomponentComponent } from './labelcomponent/labelcomponent.component';
import { CollabaratorComponent } from './collabarator/collabarator.component';
import { MatChipsModule } from "@angular/material/chips";
import { DragDropModule } from '@angular/cdk/drag-drop';
import { CreatecollabaratorComponent } from './createcollabarator/createcollabarator.component';
import { SearchdataPipe } from './notes/searchdata.pipe';
@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterComponent,
    ForgotComponent,
    ResetComponent,
    VerifyComponent,
    HeaderComponent,
    FundooNotesComponent,
    NotesComponent,
    SetremainderComponent,
      EditnotesComponent,
    LabelsComponent,
    TrashComponent,
    ArchiveComponent,
    LabelcomponentComponent,
    CollabaratorComponent,
    CreatecollabaratorComponent,
    SearchdataPipe
  ],
  imports: [
    BrowserModule, AppRoutingModule, BrowserAnimationsModule, MatCardModule, MatInputModule, MatFormFieldModule, MatAutocompleteModule, FormsModule, ReactiveFormsModule, DragDropModule, MatButtonModule, MatIconModule, HttpClientModule, RouterModule, MatProgressSpinnerModule, NgxSpinnerModule, LayoutModule, MatToolbarModule, MatSidenavModule, MatListModule, MatTooltipModule, MatMenuModule, MatGridListModule, MatDatepickerModule, MatNativeDateModule, MatExpansionModule, NgxMaterialTimepickerModule.forRoot(), FlexLayoutModule, MatDialogModule, MatSelectModule, MatChipsModule
  ],
  providers: [CommonlabelService, SelectlabelService, TrashService, RemainderService, ArchiveService, DataService, LabelService, CommonService, AuthGuard, CookieService, NoteserviceService,
    {
      provide: HTTP_INTERCEPTORS,
      useClass: InterceptorsService,
      multi: true
    }
  ]
  ,
  bootstrap: [AppComponent]
})
export class AppModule { }
