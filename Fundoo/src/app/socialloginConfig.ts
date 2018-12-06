import { AuthServiceConfig, FacebookLoginProvider, GoogleLoginProvider} from "angular-6-social-login";
import { constants } from './constants/constants';
export function getAuthServiceConfigs() {


  let config = new AuthServiceConfig([
    {
      id: FacebookLoginProvider.PROVIDER_ID,
      provider: new FacebookLoginProvider(constants.facebookClientId)
    },

    {
      id: GoogleLoginProvider.PROVIDER_ID,
      provider: new GoogleLoginProvider(constants.googleClientId)
    } 
 
  ]);
  return config;
}
