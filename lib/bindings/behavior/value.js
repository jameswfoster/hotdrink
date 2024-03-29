/**
 * @fileOverview <p>{@link hotdrink.bindings.behavior.value}</p>
 * @author John Freeman
 */

//provides("hotdrink.controller.behavior.value);

(function () {

  /**
   * @name bindRead
   * @memberOf hotdrink.bindings.behavior.value
   * @description
   *   Registers a listener with the view. Whenever the view changes, the
   *   listener will read its value, set the bound variable in the model, and
   *   trigger an update of the model.
   * @public
   * @static
   * @function
   * @param {concept.view.View} view
   * @param {concept.view.View -> Listener -> ()} onChange
   * @param {concept.view.View -> concept.model.Value} read
   * @param {hotdrink.model.Controller} model
   * @param {String} variable
   */
  var bindRead = function (view, onChange, read, model, v) {
    var vv = model.getMore(v);
    ASSERT(vv.cellType === "interface",
      "cannot set non-interface (" + vv.celType + ") variable");

    var readListener = function () {
      LOG("reading #" + $(view).attr("id"));
      var maybe = read(view);
      if ("value" in maybe) {
        model.set(v, maybe.value);
        model.update();
      } else if ("error" in maybe) {
        WARNING("validation error: " + maybe.error);
      } else {
        ERROR("expected error monad from read");
      }
    };

    onChange(view, debounce(readListener, 500));
  };

  /**
   * @name bindWrite
   * @memberOf hotdrink.bindings.behavior.value
   * @description
   *   Registers a listener with the model. Whenever the bound variable
   *   changes, the listener will read its value and write the view.
   * @public
   * @static
   * @function
   * @param {hotdrink.model.Controller} model
   * @param {String} variable
   * @param {concept.view.View -> concept.model.Value -> ()} write
   * @param {concept.view.View} view
   */
  var bindWrite = function (model, v, write, view) {
    var writeListener = function (model2) {
      ASSERT(model2 === model,
        "listening for one model, but heard another");
      LOG("writing #" + $(view).attr("id"));
      var value = model.get(v);
      write(view, value);
    };

    model.observe(v + ".value", writeListener);
  };

  /**
   * @name hotdrink.controller.behavior.value
   * @namespace
   *   Bind widgets to values in the model. Model of
   *   {@link concept.view.Behavior}.
   */
  namespace.extend("hotdrink.bindings.behavior.value", {
    bindRead : bindRead,
    bindWrite : bindWrite
  });

}());

