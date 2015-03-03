declare module Tops {
    export interface IPeanutClient {
        showServiceMessages(messages:IServiceMessage[]): void;
        hideServiceMessages(): void;
        showError(errorMessage:string): void;
        showMessage(messageText:string): void;
        initialize(applicationPath:string, successFunction?:() => void);
        showWaiter(message:string) : void;
        hideWaiter() : void;
        showProgress(message: string) : void;
        setProgress(count: number) : void;

        peanut: Tops.Peanut;
        viewModel: any;
        serviceUrl: string;
        applicationPath: string;
    }

    export interface IMessageManager {
        addMessage : (message:string, messageType:number) => void;
        setMessage  : (message:string, messageType:number) => void;
        clearMessages : (messageType:number)=> void;
        setServiceMessages : (messages:Tops.IServiceMessage[]) => void;
    }


    export interface IMainViewModel {
        init(applicationPath: string, successFunction?: () => void);
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

}