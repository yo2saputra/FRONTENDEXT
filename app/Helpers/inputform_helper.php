<?php

function getTextVertical($id, $name, $label, $size, $placeholder)
{
    $output = '';
    $output .= '
            <div class="col-sm-' . $size . '">
                <div class="form-group">
                <label>' . $label . '</label>
                <input type="text" id="' . $id . '" name="' . $name . '" class="form-control form-control-sm" placeholder="' . $placeholder . '">
                <span class="error invalid-feedback error' . ucfirst($id) . '"></span>
                </div>
            </div>
            ';
    return $output;
}

function getTextHorizontal($id, $label, $label_size, $name, $size, $placeholder)
{
    $output = '';
    $output .= '
            <label for="' . $id . '" class="col-sm-' . $label_size . ' col-form-label">' . $label . '</label>
            <div class="col-sm-' . $size . '">
                <input type="text" id="' . $id . '" name="' . $name . '" class="form-control form-control-sm"  placeholder="' . $placeholder . '">
                <span class="error invalid-feedback error' . ucfirst($id) . '"></span>
            </div>
            ';
    return $output;
}

function getTextareaVertical($id, $name, $label, $size, $rows, $placeholder)
{
    $output = '';
    $output .= '
            <div class="col-sm-' . $size . '">
                <div class="form-group">
                    <label>' . $label . '</label>
                    <textarea id="' . $id . '" name="' . $name . '" class="form-control" rows="' . $rows . '" placeholder="' . $placeholder . '"></textarea>
                    <span class="error invalid-feedback error' . ucfirst($id) . '"></span>
                </div>
            </div>
            ';
    return $output;
}
