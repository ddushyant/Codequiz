<div id="fill-question" class="row" style="display:none" data-questiontype="fill">
    <input name="answer" placeholder="Fill in the blank"></input>
</div>

<div id="coding-question" class="row" style="display:none" data-questiontype="coding">
  <table class="table table-bordered table-striped">
    <thead>
      <tr><th>Input</th><th>Output</th></tr>
    </thead>
    <tbody>
    </tbody>
  </table>
    <textarea name="answer" placeholder="write code here"></textarea>
</div>

<div id="multiple-question" class="row" style="display:none" data-questiontype="multiple">
    <div class="col-8">
      <label class="radio checked">
        <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios1" id="optionsRadios1" value="option1" data-toggle="radio" type="radio">
      </label>
      <label class="radio">
        <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios1" id="optionsRadios2" value="option1" data-toggle="radio" type="radio">
      </label>
      <label class="radio">
        <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios1" id="optionsRadios1" value="option1" data-toggle="radio" type="radio">
      </label>
      <label class="radio">
        <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios1" id="optionsRadios1" value="option1" data-toggle="radio" type="radio">
      </label>
    </div>
</div>
<div id="true-false-question" class="row" style="display:none" data-questiontype="true-false">
    <div class="col-xs-3">
      <label class="radio checked">
        <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios2" id="optionsRadios3" value="true" data-toggle="radio" type="radio">
      True
      </label>
      <label class="radio">
        <span class="icons"><span class="first-icon fui-radio-unchecked"></span><span class="second-icon fui-radio-checked"></span></span><input name="optionsRadios2" id="optionsRadios4" value="false" data-toggle="radio" type="radio">
        False
      </label>
    </div>
</div>

<button id="modal-prev" type="button" class="btn">Prev</button>
<button id="modal-next" type="button" class="btn">Next</button>
<div id="modal-question">
</div>
