import { Component, OnInit } from "@angular/core";
import { DomSanitizer } from "@angular/platform-browser";
import { MatIconRegistry } from "@angular/material";
import { DataService } from "../service/data.service";
import {
  FormControl,
  FormGroupDirective,
  NgForm,
  Validators
} from "@angular/forms";
import { Router } from "@angular/router";
import { CookieService } from "angular2-cookie/services/cookies.service";
import { AuthService, FacebookLoginProvider, GoogleLoginProvider } from 'angular-6-social-login';
@Component({
  selector: "app-login",
  templateUrl: "./login.component.html",
  styleUrls: ["./login.component.css"]
})
export class LoginComponent {
  model: any = {};
  public iserror = false;
  public errorMessage = "";
  constructor(private socialAuthService: AuthService, iconRegistry: MatIconRegistry, sanitizer: DomSanitizer, private data: DataService, private router: Router, private _cookieService: CookieService) {
    iconRegistry.addSvgIcon(
      "fb",
      sanitizer.bypassSecurityTrustResourceUrl("assets/img/login/fb.svg")
    );
    iconRegistry.addSvgIcon(
      "google",
      sanitizer.bypassSecurityTrustResourceUrl("assets/img/login/google.svg")
    );
  }
  email = new FormControl("", [Validators.required, Validators.email]);
  /**
  * @method getErrorMessage()
  * @return void
  * @description Function to error validation
  */
  getErrorMessage() {
    if (this.email.hasError("required")) {
      return "must enter a value";
    } else if (this.email.hasError("email")) {
      return "Not a valid email";
    } else {
      return "";
    }
  }
  /**
  * @method getPassErrorMessage()
  * @return void
  * @description Function to error validation
  */
  pass = new FormControl("", [Validators.required]);
  getPassErrorMessage() {
    if (this.pass.hasError("required")) {
      return "must enter a value";
    } else {
      return "must enter 6 digit password";
    }
  }
  /**
  * @method login()
  * @return void
  * @description Function to error validation
  */
  login() {
    this._cookieService.put('email', this.model.email);
    let obs = this.data.UserLoginData(this.model);
    obs.subscribe(
      (res: any) => {
        if (res.message == "200") {
          localStorage.setItem('token', res.token);
          this.router.navigate(['/fundoo'])
        } else if (res.message == "404") {
          alert("user not found");
        }
        else if (res.message == "401") {
          alert("Email is Not Registered");
        }
        else {
          alert("invalid password");
        }
      },
      error => {
        this.iserror = true;
        this.errorMessage = error.message;
      });
  }








  public socialSignIn(socialPlatform: string) {
    debugger;
    let socialPlatformProvider;
    if (socialPlatform == "facebook") {
      socialPlatformProvider = FacebookLoginProvider.PROVIDER_ID;
    } else if (socialPlatform == "google") {
      socialPlatformProvider = GoogleLoginProvider.PROVIDER_ID;
    }

    this.socialAuthService.signIn(socialPlatformProvider).then(userData => {
      debugger;
      console.log(socialPlatform + " sign in data : ", userData);
      // Now sign-in with userData
      // ...
      // this.sendToRestApiMethod(
        // userData.token,
       alert(userData.email);
        // userData.image,
        // userData.name
      // );
    });
  }
flag;
mail;
name;
Error;



  // sendToRestApiMethod(
  //   token: string,
  //   email: string,
  //   profilepic: string,
  //   first_name: string
  // ): void {
  //   debugger;

  //   let data = [{ username: first_name, email: email, profilepic: profilepic }];
  //   this.service.SocialLogin(data).subscribe((Statusdata: any) => {
  //     console.log(Statusdata);
  //     debugger;
  //     this.flag = Statusdata.status;
  //     this.mail = Statusdata.email;
  //     this.name = Statusdata.name;
  //     if (this.flag == 1) {
  //       localStorage.setItem("email", "prashantcoolboy1@rediffmail.com");
  //       localStorage.setItem("uname", "Prashant Deshmukh");
  //       // this.auth.sendToken(this.mail);
  //       this.router.navigate(["/FundooNotes"]);
  //     } else {
  //       this.Error = true;
  //     }
  //   });
  // }



















}
