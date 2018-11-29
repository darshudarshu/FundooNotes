import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { ActivatedRoute } from '@angular/router';
@Injectable({
  providedIn: "root"
})
export class DataService {
 /**
  * Api urls
  */
  private urlRegister = "http://localhost/codeigniter/registration";
  private urlLogin = "http://localhost/codeigniter/login";
  private urlForgot = "http://localhost/codeigniter/forgotPassword";
  private urlReset = "http://localhost/codeigniter/resetPassword";
  private urlGetEmail = "http://localhost/codeigniter/getEmailId";
  private urlVerifyEmail = "http://localhost/codeigniter/veryfyEmailId";


  constructor(private http: HttpClient, private route: ActivatedRoute) { }
  /**
    * @method UserLoginData() 
    * @return observable data
    * @param login 
    * @description Function to send login data to server
    */
  UserLoginData(login) {
    let userLoginData = new FormData();
    userLoginData.append("email", login.email)
    userLoginData.append("password", login.pass)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlLogin, userLoginData, otheroption)
  }
  /**
    * @method UserRegistrationData() 
    * @return observable data
    * @param register
    * @description Function to send register data to server
    */
  UserRegistrationData(register) {
    let userRegisterData = new FormData();
    userRegisterData.append("username", register.name)
    userRegisterData.append("email", register.email)
    userRegisterData.append("mobilenumber", register.number)
    userRegisterData.append("password", register.pass)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlRegister, userRegisterData, otheroption)
  }
  /**
    * @method userPasswordRecoveryData() 
    * @return observable data
    * @param forgot 
    * @description Function to send forgot to server
    */
  userPasswordRecoveryData(forgot) {
    let userPassRecoveryData = new FormData();
    userPassRecoveryData.append("email", forgot.email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlForgot, userPassRecoveryData, otheroption)
  }
  /**
    * @method UserResetData() 
    * @return observable data
    * @param reset 
    * @description Function to send reset data to server
    */

  UserResetData(reset) {
    let userResetData = new FormData();
    userResetData.append("token", this.route.snapshot.queryParamMap.get('token'));
    userResetData.append("pass", reset.pass)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlReset, userResetData, otheroption)
  }
  /**
    * @method getEmail() 
    * @return observable data
    * @param reset
    * @description Function to send get email from server
    */
  getEmail(reset) {
    let urlTocken = new FormData();
    urlTocken.append("token", this.route.snapshot.queryParamMap.get('token'));
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlGetEmail, urlTocken, otheroption)
  }
  /**
    * @method verifyemail() 
    * @return observable data
    * @description Function to send verify  email 
    */
  verifyemail() {
    let verifyEmailId = new FormData();
    verifyEmailId.append("token", this.route.snapshot.queryParamMap.get('token'));
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlVerifyEmail, verifyEmailId, otheroption)
  }
  /**
    * @method loggedIn() 
    * @return boolean
    * @description Function to check the token 
    */
  loggedIn() {
    return !!localStorage.getItem('token');
  }
  /**
    * @method getToken() 
    * @return string
    * @description Function to get the token
    */
  getToken() {
    return localStorage.getItem('token');
  }

}
