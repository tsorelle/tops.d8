/**
 * Created by Terry on 2/19/2015.
 */
///<reference path='../Tops.Peanut/Peanut.d.ts' />
/// <reference path="../Tops.Peanut/Peanut.ts" />
/// <reference path="../typings/bootstrap/bootstrap.d.ts" />
module Tops {

    export class waitMessage {
        private static waitDialog : any = null;
        private static waiterType : string = 'spin-waiter';
        private static templates = Array<string>();

        public static addTemplate(templateName: string, content: string) {
            waitMessage.templates[templateName] = content;
        }


        public static setWaiterType(waiterType: string) {
            waitMessage.waiterType = waiterType;
            waitMessage.waitDialog = $(waitMessage.templates[waiterType]);
            return waitMessage.waitDialog;
        }

        public static show(message: string = 'Please wait ...', waiterType : string = 'spin-waiter') {
            var div = waitMessage.setWaiterType(waiterType);
            var span =  div.find('#wait-message');
            span.text(message);
            div.modal();
        }

        public static setMessage(message: string) {
            if (waitMessage.waitDialog) {
                var span = waitMessage.waitDialog.find('#wait-message');
                span.text(message);
            }
        }

        public static setProgress(count: number, showLabel: boolean = false) {
            if (waitMessage.waiterType == 'progress-waiter') {
                var bar = waitMessage.waitDialog.find('#wait-progress-bar');
                var percent = count + '%';
                bar.css('width', percent);
                if (showLabel) {
                    bar.text(percent);
                }
            }
        }

        public static hide() {
            if (waitMessage.waitDialog) {
                waitMessage.waitDialog.modal('hide');
            }
        }
    }

    class messageManager implements IMessageManager {
        static instance:messageManager;

        static errorClass: string = "service-message-error";
        static infoClass: string = "service-message-information";
        static warningClass: string = "service-message-warning";

        public errorMessages = ko.observableArray([]);
        public infoMessages = ko.observableArray([]);
        public warningMessages = ko.observableArray([]);


        public addMessage = (message:string, messageType:number):void => {
            switch (messageType) {
                case Tops.Peanut.errorMessageType :
                    this.errorMessages.push({type: messageManager.errorClass, text: message});
                    break;
                case Tops.Peanut.warningMessageType:
                    this.warningMessages.push({type: messageManager.warningClass, text: message});
                    break;
                default :
                    this.infoMessages.push({type: messageManager.infoClass, text: message});
                    break;
            }
        };

        public setMessage = (message:string, messageType:number):void => {

            switch (messageType) {
                case Tops.Peanut.errorMessageType :
                    this.errorMessages([{type: messageManager.errorClass, text: message}]);
                    break;
                case Tops.Peanut.warningMessageType:
                    this.warningMessages([{type: messageManager.warningClass, text: message}]);
                    break;
                default :
                    this.infoMessages([{type: messageManager.infoClass, text: message}]);
                    break;
            }
        };

        public clearMessages = (messageType:number = Tops.Peanut.allMessagesType):void => {
            if (messageType == Tops.Peanut.errorMessageType || messageType == Tops.Peanut.allMessagesType) {
                this.errorMessages([]);
            }
            if (messageType == Tops.Peanut.warningMessageType || messageType == Tops.Peanut.allMessagesType) {
                this.warningMessages([]);
            }
            if (messageType == Tops.Peanut.infoMessageType || messageType == Tops.Peanut.allMessagesType) {
                this.infoMessages([]);
            }
        };

        public setServiceMessages = (messages:Tops.IServiceMessage[]):void => {
            var count = messages.length;
            var errorArray = [];
            var warningArray = [];
            var infoArray = [];
            for (var i = 0; i < count; i++) {
                var message = messages[i];
                switch (message.MessageType) {
                    case Tops.Peanut.errorMessageType :
                        errorArray.push({type: messageManager.errorClass, text: message.Text});
                        break;
                    case Tops.Peanut.warningMessageType:
                        warningArray.push({type: messageManager.warningClass, text: message.Text});
                        break;
                    default :
                        infoArray.push({type: messageManager.infoClass, text: message.Text});
                        break;
                }
            }
            this.errorMessages(errorArray);
            this.warningMessages(warningArray);
            this.infoMessages(infoArray);
        };
    }

    // Class
    export class Application implements Tops.IPeanutClient {
        constructor(currentViewModel: any) {
            var me = this;
            me.viewModel = currentViewModel;
            me.peanut = new Tops.Peanut(me);
            Application.current = me;
        }

        static current: Application;
        applicationPath: string = "/";
        peanut: Tops.Peanut;
        viewModel: any;
        serviceUrl: string = "topsService.php";


        public getHtmlTemplate(name: string, successFunction: (htmlSource: string) => void) {
            var parts = name.split('-');
            var fileName = parts[0] + parts[1].charAt(0).toUpperCase() + parts[1].substring(1);
            var htmlSource = this.applicationPath + 'assets/templates/' + fileName + '.html';
            $.get(htmlSource, successFunction);
        }

        private registerComponent(name: string, vm: any, successFunction?: () => void) {
            var me = this;

            me.getHtmlTemplate(name, function (htmlSource: string) {
                ko.components.register(name, {
                    viewModel: {instance: vm}, // testComponentVm,
                    template: htmlSource
                });
                if (successFunction) {
                    successFunction();
                }
            });
        }

        public loadWaitMessageTemplate(templateName: string, successFunction: () => void) {
            this.getHtmlTemplate(templateName, function (htmlSource: string) {
                waitMessage.addTemplate(templateName, htmlSource);
                successFunction();
            });
        }

        public initialize(applicationPath: string, successFunction?: () => void) {
            var me = this;
            me.setApplicationPath(applicationPath);
            me.serviceUrl = this.applicationPath + this.serviceUrl;
            messageManager.instance = new messageManager();
            me.registerComponent('messages-component', messageManager.instance, function () {
                me.loadWaitMessageTemplate('spin-waiter', function () {
                    me.loadWaitMessageTemplate('progress-waiter', function () {
                        if (successFunction) {
                            successFunction();
                        }
                    })
                });
            });
        }

        setApplicationPath(path: string): void {
            var me = this;
            if (path) {
                me.applicationPath = "";
                if (path.charAt(0) != "/")
                    me.applicationPath = "/";
                me.applicationPath = me.applicationPath + path;
                if (path.charAt(path.length - 1) != "/")
                    me.applicationPath = me.applicationPath + "/";
            }
            else
                me.applicationPath = "/";
        }

        showServiceMessages(messages: Tops.IServiceMessage[]): void {
            messageManager.instance.setServiceMessages(messages);
        }

        hideServiceMessages(): void {
            messageManager.instance.clearMessages();
        }

        showError(errorMessage: string): void {
            // peanut uses this to display exceptions
            if (errorMessage) {
                messageManager.instance.addMessage(errorMessage,Peanut.errorMessageType);
            }
            else {
                messageManager.instance.clearMessages(Peanut.errorMessageType);
            }
        }

        showMessage(messageText: string): void {
            if (messageText) {
                messageManager.instance.addMessage(messageText,Peanut.infoMessageType);
            }
            else {
                messageManager.instance.clearMessages(Peanut.infoMessageType);
            }
        }

        // Application level message display functions
        showErrorMessage(messageText: string): void {
            if (messageText) {
                messageManager.instance.setMessage(messageText,Peanut.errorMessageType);
            }
            else {
                messageManager.instance.clearMessages(Peanut.errorMessageType);
            }
        }

        showInfoMessage(messageText: string): void {
            if (messageText) {
                messageManager.instance.setMessage(messageText,Peanut.infoMessageType);
            }
            else {
                messageManager.instance.clearMessages(Peanut.infoMessageType);
            }
        }

        public showWaiter(message: string = "Please wait . . .") {
            waitMessage.show(message);
        }

        public hideWaiter() {
            waitMessage.hide();
        }

        public showProgress(message: string = "Please wait . . .") {
            waitMessage.show(message, 'progress-waiter');
        }

        public setProgress(count: number) {
            waitMessage.setProgress(count);
        }

        /*
        // static wait message example

        public showWaiter(message: string = "Please wait . . .") {
            $("#load-window-text").text(message);
            //Get the window height and width
            var winH = $(window).height();
            var winW = $(window).width();
            var dialogId = "#load-window";
            //Set the popup window to center
            $(dialogId).css('top', winH / 2 - $(dialogId).height() / 2);
            $(dialogId).css('left', winW / 2 - $(dialogId).width() / 2);

            $("#load-message").show();
            $("#modal-mask").show();
            $(dialogId).show();
        }

        public hideWaiter(timeout: number = 0) {
            $('#load-window').hide();
            $("#modal-mask").hide();
            $("#load-message").hide();
        }
         */
    }


}
