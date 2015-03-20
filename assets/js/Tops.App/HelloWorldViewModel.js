/**
* Created by Terry on 3/17/2015.
*/
/// <reference path='../typings/knockout/knockout.d.ts' />
/// <reference path="./App.ts" />
/// <reference path="../Tops.Peanut/Peanut.ts" />
/// <reference path='../Tops.Peanut/Peanut.d.ts' />
var Tops;
(function (Tops) {
    var HelloWorldViewModel = (function () {
        // Constructor
        function HelloWorldViewModel() {
            var me = this;
            Tops.HelloWorldViewModel.instance = me;
            me.application = new Tops.Application(me);
            me.peanut = me.application.peanut;
        }
        HelloWorldViewModel.prototype.onButtonClick = function () {
            // alert('Hello World');
            var me = this;
            me.peanut.executeService('HelloWorld', null, function (serviceResponse) {
                me.application.hideWaiter();
                if (serviceResponse.Result == Tops.Peanut.serviceResultSuccess) {
                    alert('Success!');
                }
            }).fail(function () {
                alert('Failed');
            });
        };

        /**
        * @param applicationPath - root path of application or location of service script
        * @param successFunction - page inittializations such as ko.applyBindings() go here.
        *
        * Call this function in a script at the end of the page following the closing "body" tag.
        * e.g.
        *      ViewModel.init('/', function() {
        *          ko.applyBindings(ViewModel);
        *      });
        *
        */
        HelloWorldViewModel.prototype.init = function (applicationPath, successFunction) {
            var me = this;

            // setup messaging and other application initializations
            me.application.initialize(applicationPath, function () {
                // do view model initializations here.
                if (successFunction) {
                    successFunction();
                }
            });
        };
        return HelloWorldViewModel;
    })();
    Tops.HelloWorldViewModel = HelloWorldViewModel;
})(Tops || (Tops = {}));

Tops.HelloWorldViewModel.instance = new Tops.HelloWorldViewModel();
window.ViewModel = Tops.HelloWorldViewModel.instance;
//# sourceMappingURL=HelloWorldViewModel.js.map
