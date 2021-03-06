/// <reference path="../../../../../typings/tsd.d.ts" />

module Petition
{
    export class MovementTypeToggle
    {

        /**
         * El id del modelo
         */
        public id: number;

        /**
         * El url a donde apunta el ajax
         */
        public url: string;

        /**
         * El metodo que ajax necesita
         * @type {string}
         */
        private _method = 'POST';

        /**
         * El modelo que representa lo que llega del servidor
         */
        private _model = {
            data: {},
            ingress: null,
        };

        /**
         * Si esta instancia posee el id y el url de destino,
         * procede a ejecutar el ajax necesario.
         * @param id
         * @param url
         */
        constructor(id: number = null, url: string = null) {
            this.id  = id;
            this.url = url;

            if (this.id && this.url) {
                this.getModel().changeInputs();
            }
        }

        public selectWatcher(
            $element: JQuery,
            $related: JQuery = null
        ): Petition.MovementTypeToggle {
            var self = this;
            $element.change(function () {
                self.id = $(this).val();
                self.getModel();
                if ($related !== null) {
                    $related.trigger('change');
                }
            });

            return this;
        }

        /**
         * Busca en el API el tipo de stock relacionado a
         * la selecccion y chequea que el input sea valido.
         * @returns {Petition.MovementTypeToggle}
         */
        public getModel(): Petition.MovementTypeToggle {
            var self = this;

            var request = $.ajax({
                method: this._method,
                url: this.url,
                data: {
                    id: this.id
                },
                dataType: "json"
            });

            request.done(function (data) {
                if (data.status == true) {
                    self._model.data    = data.model;
                    self._model.ingress = data.ingress;
                    self.changeInputs();
                } else if (data.status == false) {
                    console.log(data);
                } else {
                    console.log(data);
                }
            });

            request.fail(function (data) {
                console.log(data);
            });

            return this;
        }

        /**
         * Cambia el input de algun item sabiendo el stock y el tipo de movimiento.
         * @returns {Petition.MovementTypeToggle}
         */
        public changeInputs(): Petition.MovementTypeToggle {
            var $element = $('.model-number-input');

            if ($element.length < 1) {
                return this;
            }

            if (this.isModelIngress()) {
                $element
                    .attr('value', 0)
                    .attr('min', 1)
                    .attr('max', null)
                    .attr('step', null);

                return this;
            }

            // debemos chequear los inputs porque es salida
            this.checkInputValue($element);

            return this;
        }

        /**
         * Nos interesa saber si los elementos son validos en cuanto su
         * stock debido a que el usuario puede cambiar el tipo de
         * entrada del pedido o nota, debemos chequear que el
         * stock sea apropiado para entrada o salida.
         * @param $element
         */
        private checkInputValue($element: JQuery): void {
            // controla los items que han sido sacados de los ya seleccionados.
            var i = 0;

            // si algun item fue eliminado esto sera verdadero.
            var removedItems = false;

            $element.each((key, HTMLElement) => {
                var $input        = $(HTMLElement);
                var stock = this.getOriginalStock($input);

                // chequeamos que el stock no sea 0
                if (stock <= 0) {
                    i++;
                    removedItems = true;

                    // esta funcion esta fuera de esta clase.
                    $input.parent()
                        .siblings('div')
                        .find('.itemBag-remove-item')
                        .trigger('click');
                }

                // si el item es valido y su stock es mayor que cero, entonces
                // ajustamos el valor del input al original, para
                // eliminar lo que sea que haya puesto el
                // usuario (cambio de entrada a salida)
                this.setInputStockValue($input, stock);

                var min = stock > 1
                    ? 1
                    : this.findInputMinimum(stock);

                $input.attr('min', min)
                    .attr('max', null);
            });

            if (removedItems) {
                var string = i == 1
                    ? 'Removido 1 Item sin existencia.'
                    : 'Removidos ' + i + ' Items sin existencia.';
                var html   = '<div class="remove-item-msg">' +
                    '<label for="itemBag" class="control-label col-sm-8">' +
                    string + '</label></div>';

                // en el div donde estan los items seleccionados,
                // añadimos este mensaje que se borrara en 10 segundos de la vista.
                $('#itemBag').append(html);
                $('.remove-item-msg').animate({opacity: 1}, 10000, 'linear', function () {
                    $(this).animate({opacity: 0}, 2000, 'linear', function () {
                        $(this).remove();
                    });
                });
            }
        }

        protected setInputStockValue($input:JQuery, stock:number):void {
            if (this.isModelEgress()) {
                $input.val(stock.toString());

                return;
            }

            $input.val("0");
        }

        /**
         * Identifica cual es el stock del articulo
         * para saber si este esta o no en existencia.
         *
         * @param $input
         */
        protected getOriginalStock($input:JQuery):number {
            var stock = $input.data('stock-plain');

            if (stock === undefined) {
                throw new Error('No se conoce el stock del articulo para continuar.')
            }

            return stock;
        }

        /**
         * Nos interesa saber si el modelo es de tipo entrada o salida
         * @returns {boolean}
         */
        public isModelIngress(): boolean {
            return this._model.ingress === true;
        }

        /**
         * Nos interesa saber si el modelo es de tipo entrada o salida.
         * @returns {boolean}
         */
        public isModelEgress(): boolean {
            return !this.isModelIngress();
        }

        /**
         * chequea el tamaño del numero para saber cual es valor minimo del input.
         * @param value
         * @returns {number}
         */
        private findInputMinimum(value: number): number {
            if (value < .001) {
                return .00001
            }

            return .001
        }
    }
}
