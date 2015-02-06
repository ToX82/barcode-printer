<?php
function filterString($name) {
	return filter_input (INPUT_GET, $name, FILTER_SANITIZE_STRING);
}
function filterInt($name) {
	return filter_input (INPUT_GET, $name, FILTER_SANITIZE_NUMBER_INT);
}
function filterRaw($name) {
	return filter_input (INPUT_GET, $name, FILTER_UNSAFE_RAW);
}