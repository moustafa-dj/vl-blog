import { createToast } from "mosha-vue-toastify";

export function  useToast () {

    const success = function(message){
        createToast(message , {
            type: 'success',
            showIcon: true
        })
    } 

    const error = function(message) {
        createToast(message , {
            type: 'error',
            showIcon: true   
        })
    }
    return {success , error}

}