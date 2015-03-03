/**
 * Created by Terry on 2/19/2015.
 */
///<reference path='../typings/knockout/knockout.d.ts' />
/// <reference path="./App.ts" />
/// <reference path="../Tops.Peanut/Peanut.ts" />
///<reference path='../Tops.Peanut/Peanut.d.ts' />
// Module
module Tops {
    // replace all occurances of 'yourVmName' with the name of your model
    //  e.g.  yourVmName -> billingConfiguration  produces billingConfigurationViewModel
    export class TestPageViewModel implements IMainViewModel {
        static instance: Tops.TestPageViewModel;
        private application: Tops.IPeanutClient;
        private peanut: Tops.Peanut;


        // Constructor
        constructor() {
            var me = this;
            Tops.TestPageViewModel.instance = me;
            me.application = new Tops.Application(me);
            me.peanut = me.application.peanut;

        }


        messageText = ko.observable('');

        // person: KnockoutObservable<any> = ko.observable();
        // Declarations
        // Examples:
        //  templateList: KnockoutObservableArray = ko.observableArray([]);
        //  currentPage: KnockoutObservableString = ko.observable("");


        // Methods
        // test() { alert("hello"); }

        // call this funtions at end of page
        init(applicationPath: string, successFunction?: () => void) {
            var me = this;

            // setup messaging and other application initializations
            me.application.initialize(applicationPath,
            function() {
                    // me.clearPerson();
                    me.messageText('initialized.');
                    if (successFunction) {
                        successFunction();
                    }
                }
            );
        }

        onAddMessageClick() {
            var me = this;
            var msg = me.messageText();
            me.application.showMessage(msg);
            me.messageText('');
        }

        onShowSpinWaiter() {
            var count = 0;
            Tops.waitMessage.show("Hello " + (new Date()).toISOString());
            var t = window.setInterval(function() {
                if (count > 100) {
                    clearInterval(t);
                    Tops.waitMessage.hide();
                }
                else {
                    Tops.waitMessage.setMessage('Counting ' + count);
                    // Tops.waitMessage.setProgress(count,true);
                }
                count += 1;
            }, 100);

        }

        onShowWaiter() {
            var count = 0;
            Tops.waitMessage.show("Hello " + (new Date()).toISOString(), 'progress-waiter');
            var t = window.setInterval(function() {
                if (count > 100) {
                    clearInterval(t);
                    Tops.waitMessage.hide();
                }
                else {
                    Tops.waitMessage.setMessage('Counting ' + count);
                    Tops.waitMessage.setProgress(count,true);
                }
                count += 1;
            }, 100);
        }

        onHideWaiter() {
            Tops.waitMessage.hide();

        }
/*
        clearPerson() {
            var me = this;
            var initPerson =
            {
                id : 0,
                Name: "",
                Gender: "",
                Status: "New",
                Age: 0
            };
            me.person(initPerson);
        }

        onUpdatePerson() {
            var me = this;

            me.application.hideServiceMessages();
            // me.application.showErrorMessage("Testing error messages: updatePerson");

            me.peanut.executeService('UpdatePerson', me.person(),
                function (serviceResponse: Tops.IServiceResponse) {
                    if (serviceResponse.Result == Tops.Peanut.serviceResultSuccess) {

                        me.person(serviceResponse.Value);

                    }
                    else {
                        alert("Service failed");
                        me.clearPerson();
                    }
                }
            ).always(
                function() {
                    alert("Service complete.");
                }
            );
        }

        onGetPerson() {
            var me = this;
            me.application.hideServiceMessages();
            // me.application.showInfoMessage("Testing info messages: getPerson");


            me.peanut.getFromService('GetPerson', 1,
                function (serviceResponse: Tops.IServiceResponse) {
                    if (serviceResponse.Result == Tops.Peanut.serviceResultSuccess) {
                        me.person(serviceResponse.Value);
                    }
                    else {
                        alert("Service failed");
                        me.clearPerson();
                    }
                });
        }
        */
    }
}

Tops.TestPageViewModel.instance = new Tops.TestPageViewModel();
(<any>window).ViewModel = Tops.TestPageViewModel.instance;