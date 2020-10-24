export default class Gate{

    constructor(user){
        this.user = user;
    }
    isGuest(){
        return this.user.type === 'guest';
    }

    isAdmin(){
        return this.user.type === 'admin';
    }

    isDofi(){
        return this.user.type === 'dofi';
    }
    isPofi(){
        return this.user.type === 'pofi';
    }
    isAdminOrDofi(){
        if(this.user.type === 'admin' || this.user.type === 'dofi'){
            return true;
        }

    }
    isDofiOrPofi(){
        if(this.user.type === 'dofi' || this.user.type === 'pofi'){
            return true;
        }

    }
    isAdminOrDofiOrPofi(){
        if(this.user.type === 'admin' || this.user.type === 'dofi' || this.user.type === 'pofi'){
            return true;
        }

    }

}

