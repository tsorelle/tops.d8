/**
 * Created by Terry on 2/19/2015.
 */
/// <reference path="../Tops.Peanut/Peanut.ts" />
module Tops {
    // Class
    export class Application implements Tops.IPeanutClient {
        constructor(currentViewModel: any) {
            var me = this;
            me.viewModel = currentViewModel;
            me.peanut = new Tops.Peanut(me);
            Application.current = me;
        }

        static current: Application;
        static errorClass: string = "service-message-error";
        static infoClass: string = "service-message-information";
        static warningClass: string = "service-message-warning";
        applicationPath: string = "/";
        peanut: Tops.Peanut;
        viewModel: any;
        serviceUrl: string = "topsService.php";

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
            var me = this;
            var errorText = me.peanut.getErrorMessagesAsUL(messages);
            var infoText = me.peanut.getInfoMessagesAsUL(messages);

            me.showErrorMessage(errorText);
            me.showInfoMessage(infoText);
        }

        hideServiceMessages(): void {
            var me = this;
            me.showErrorMessage(null);
            me.showInfoMessage(null);
        }

        showError(errorMessage: string): void {
            // peanut uses this to display exceptions
            var me = this;

            if (errorMessage)
                me.showErrorMessage(errorMessage);
            //                me.showMessage("<div class='" + Application.errorClass +
//                    "'>" + errorMessage + "</div>");
            else
                me.showMessage(null);

        }

        showMessage(messageText: string): void {
            // alert("Message: " + messageText);
            var me = this;
            me.showInfoMessage(messageText);
            /*
             if (messageText) {
             $("#messages-text").html(messageText);
             $("#messages").show();
             }
             else {
             $("#messages").hide();
             $("#messages-text").html("");
             }
             */
        }

        // Application level message display functions
        showErrorMessage(messageText: string): void {
            var me = this;
            me.setMessage(messageText, "error");
        }

        showInfoMessage(messageText: string): void {
            var me = this;
            me.setMessage(messageText, "info");
        }

        setMessage(message: string, prefix: string) {
            if (message) {
                $("#" + prefix + "Text").html(message);
                $("#" + prefix + "Messages").show();
            }
            else {
                $("#" + prefix + "Text").html("");
                $("#" + prefix + "Messages").hide();
            }
        }

        showWaiter(message: string = "Please wait . . .") {
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

        hideWaiter(timeout: number = 0) {
            $('#load-window').hide();
            $("#modal-mask").hide();
            $("#load-message").hide();
        }

    }
}
