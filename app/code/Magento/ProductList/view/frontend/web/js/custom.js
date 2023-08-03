define([], function () {
    'use strict';
  
    showPersonal()
    return {
        showPersonal:function(){
            document.getElementsByClassName('partner_account').style.display ='none';
            document.getElementsByClassName('personal_account').style.display ='block';
        },
        showPartner:function(){
            document.getElementsByClassName('partner_account').style.display ='block';
            document.getElementsByClassName('personal_account').style.display ='none';
        }
    }
  
  });