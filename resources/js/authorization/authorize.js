/**
 * define the authorize function that can called in template
 * prototype is away to inherent class so we can add authorize function directly to component instance without injection mechanism
 */
import policies from './policies';

export default {
    install (Vue, options) {

        Vue.prototype.authorize = function (policy, model) {
            //make sure that the user has successfully signedIn
            if (! window.Auth.signedIn) return false; //signedIn defined in app.blade.php

            if (typeof policy == 'string' && typeof model == 'object' ) {
                const user = window.Auth.user;

                return policies[policy](user, model);
                //policies hold all policies in policies.js
                //this function will be called something like -> authorize('modify', answer)
            }
        }

        Vue.prototype.signedIn = window.Auth.signedIn; // SO signedIn can be accessable to all components

    }
}
