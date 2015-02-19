/**
 * Created by Terry on 2/19/2015.
 */
///<reference path='../typings/knockout/knockout.d.ts' />
///<reference path='../typings/jquery/jquery.d.ts' />
module Tops {
    export interface IPeanutClient {
        showServiceMessages(messages: IServiceMessage[]): void;
        hideServiceMessages(): void;
        showError(errorMessage: string): void;
        showMessage(messageText: string): void;
        peanut: Tops.Peanut;
        viewModel: any;
        serviceUrl: string;
        applicationPath: string;
    }

    export interface IServiceMessage {
        MessageType: number;
        Text: string;
    }

    export interface IServiceResponse {
        Messages: IServiceMessage[];
        Result: number;
        Value: any;
        Data: any;
    }

    export interface INameValuePair {
        Name: string;
        Value: string;
    }

    export class KeyValueDTO implements Tops.INameValuePair {
        public Name: string;
        public Value: string;
    }



    export class Peanut {
        constructor(public clientApp: IPeanutClient) {
        }
        // private foo: any;
        // private serviceType: string = 'php';

        static allMessagesType: number = -1;
        static infoMessageType: number = 0;
        static errorMessageType: number = 1;
        static warningMessageType: number = 2;

        static serviceResultSuccess: number = 0;
        static serviceResultPending: number = 1;
        static serviceResultWarnings: number = 2;
        static serviceResultErrors: number = 3;
        static serviceResultServiceFailure: number = 4;
        static serviceResultServiceNotAvailable: number = 5;

        parseErrorResult(result: any): string {
            var me = this;
            var errorDetailLevel = 4; // verbosity control to be implemented later
            var responseText = "An unexpected system error occurred.";
            try {
                // WCF returns a big whopping HTML page.  Could add code later to parse it but for now, just status info.
                if (result.status) {
                    if (result.status == '404')
                        return responseText + " The web service was not found.";
                    else {
                        responseText = responseText + " Status: " + result.status;
                        if (result.statusText)
                            responseText = responseText + " " + result.statusText
                    }
                }
            }
            catch (ex) {
                responseText = responseText + " Error handling failed: " + ex.toString;
            }
            return responseText;

        }


        getInfoMessages(messages: IServiceMessage[]): string[]{
            var _peanut = this;
            // var me = this;
            var result = new Array<string>();

            var j = 0;
            for (var i = 0; i < messages.length; i++) {
                var message = messages[i];
                if (message.MessageType == Tops.Peanut.infoMessageType)
                    result[j++] = message.Text;
            }

            return result;
        }


        getNonErrorMessages(messages: IServiceMessage[]): string[] {
            var _peanut = this;
            var me = this;
            var result = new Array<string>();

            var j = 0;
            for (var i = 0; i < messages.length; i++) {
                var message = messages[i];
                if (message.MessageType != Tops.Peanut.errorMessageType)
                    result[j++] = message.Text;
            }

            return result;
        }


        getErrorMessages(messages: IServiceMessage[]): string[] {
            var _peanut = this;
            var result = new Array<string>()

            var j = 0;
            for (var i = 0; i < messages.length; i++) {
                var message = messages[i];
                if (message.MessageType == Tops.Peanut.errorMessageType)
                    result[j++] = message.Text;
            }

            return result;
        }


        getErrorMessagesWithBR(messages: IServiceMessage[]): string {
            var me = this;
            var errors = me.getErrorMessages(messages);
            var errorString = "";
            if (errors.length > 0) {
                for (var i = 0; i < errors.length; i++) {
                    errorString = errorString + (i > 0 ? "<br>" : "") + errors[i];
                }
            }
            return errorString;
        }

        getNonErrorMessagesWithBr(messages: IServiceMessage[]): string {
            var me = this;
            var infos = me.getInfoMessages(messages);
            var infoString = "";
            if (infos.length > 0) {
                for (var i = 0; i < infos.length; i++) {
                    infoString = infoString + (i > 0 ? "<br>" : "") + infos[i];
                }
            }
            return infoString;
        }


        getErrorMessagesAsUL(messages: IServiceMessage[]): string {
            var me = this;
            var errors = me.getErrorMessages(messages);
            var errString = me.messagesToUL(errors);
            return errString;
        }

        getInfoMessagesAsUL(messages: IServiceMessage[]): string {
            var me = this;
            var infos = me.getInfoMessages(messages);
            var infoString = me.messagesToUL(infos);
            return infoString;
        }


        getMessagesAsUL(messages: IServiceMessage[], errClass: string, infoClass: string, warningClass?: string): string {
            // Use this if all messages in a single block with class types
            var me = this;
            if (!messages)
                return "";
            if (!warningClass)
                warningClass = infoClass;
            var result = "<ul>";
            for (var i = 0; i < messages.length; i++) {
                var message = messages[i];
                var className = errClass;
                if (message.MessageType == Peanut.infoMessageType)
                    className = infoClass;
                else if (message.MessageType == Peanut.warningMessageType)
                    className = warningClass;
                result = result + "<li class='" + className + "'>" + message.Text + "</li>";
            }

            return result + "</ul>";
        }

        getMessagesText(messages: IServiceMessage[]): string[] {
            var result = new Array<string>();
            var j = 0;
            for (var i = 0; i < messages.length; i++) {
                var message = messages[i];
                result[j++] = message.Text;
            }
            return result;
        }


        hideServiceMessages(): void {
            var _peanut = this;
            if (_peanut.clientApp.viewModel) {
                var viewModel: any = _peanut.clientApp.viewModel;
                if (typeof (viewModel.hideServiceMessages) !== undefined && viewModel.hideServiceMessages != null) {
                    viewModel.hideServiceMessages();
                    return;
                }
            }

            _peanut.clientApp.hideServiceMessages();
        }

        showServiceMessages(serviceResponse: IServiceResponse): void {
            var _peanut = this;
            if (serviceResponse == null || serviceResponse.Messages == null || serviceResponse.Messages.length == 0)
                return;

            // var vm = _peanut.getCurrentViewModel();
            if (_peanut.clientApp.viewModel) {
                var viewModel: any = _peanut.clientApp.viewModel;

                if (typeof (viewModel.showServiceMessages) !== undefined && viewModel.showServiceMessages != null) {
                    viewModel.showServiceMessages(serviceResponse.Messages);
                    return;
                }
            }

            _peanut.clientApp.showServiceMessages(serviceResponse.Messages);
        }

        handleServiceResponse(serviceResponse: IServiceResponse): boolean {
            var _peanut = this;
            _peanut.showServiceMessages(serviceResponse);
            return true;
        }

        showExceptionMessage(errorResult: any): string {
            var _peanut = this;
            var errorMessage = _peanut.parseErrorResult(errorResult);
            _peanut.clientApp.showError(errorMessage);
            return errorMessage;
        }

        messagesToUL(messages: string[]): string {
            if (messages.length > 0) {
                if (messages.length == 1) {
                    return messages[0];
                }
                else {
                    var i = 0;
                    var resultString = "<ul>";
                    while (i < messages.length) {
                        resultString = resultString + "<li>" + messages[i] + "</li>";
                        i++;
                    }
                    resultString = resultString + "</ul>";
                    return resultString;
                }
            }
            return "";
        }

        // Execute a peanut service and handle Service Response.
        executeService(serviceName: string, parameters: any = "",
                       successFunction?: (serviceResponse: IServiceResponse) => void,
                       errorFunction?: (errorMessage: string) => void) : JQueryPromise<any> {
            var _peanut = this;

            // peanut controller requires parameter as a string.
            if (!parameters)
                parameters = "";
            else  {
                parameters = JSON.stringify(parameters);
            }
            var serviceResponse: IServiceResponse;
            var serviceRequest = { "serviceCode" : serviceName, "request" : parameters};
            var serviceUrl =  _peanut.clientApp.serviceUrl; // 'topsService.php';

            var result =
                $.ajax({
                    type: "POST",
                    data: serviceRequest,
                    dataType: "json",
                    cache: false,
                    url: serviceUrl
                })
                    .done(
                    function(serviceResponse) {
                        _peanut.showServiceMessages(serviceResponse);
                        if (successFunction) {
                            successFunction(serviceResponse);
                        }
                    }
                )
                    .fail(
                    function(jqXHR, textStatus ) {
                        var errorMessage = _peanut.showExceptionMessage(jqXHR);
                        if (errorFunction)
                            errorFunction(errorMessage);
                    });

            return result;
        }

        getFromService(serviceName: string, parameters: any = "",
                       successFunction?: (serviceResponse: IServiceResponse) => void,
                       errorFunction?: (errorMessage: string) => void) : JQueryPromise<any> {
            var _peanut = this;

            // peanut controller requires parameter as a string.
            if (!parameters)
                parameters = "";

            var serviceResponse: IServiceResponse;
            var serviceParameters = {"request" :  parameters};
            var serviceRequest = { "serviceCode" : serviceName, "request" : parameters};
            var serviceUrl =  _peanut.clientApp.serviceUrl; // 'topsService.php';

            var result =
                $.ajax({
                    type: "GET",
                    data: serviceRequest,
                    dataType: "json",
                    cache: false,
                    url: serviceUrl
                })
                    .done(
                    function(serviceResponse) {
                        _peanut.showServiceMessages(serviceResponse);
                        if (successFunction) {
                            successFunction(serviceResponse);
                        }
                    }
                )
                    .fail(
                    function(jqXHR, textStatus ) {
                        var errorMessage = _peanut.showExceptionMessage(jqXHR);

                        if (errorFunction)
                            errorFunction(errorMessage);
                    });

            return result;
        }

    }
}
