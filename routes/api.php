<?php

Route::Resource('surveys', 'SurveyController')->except(['create', 'edit']);
Route::Resource('questions', 'QuestionController')->except(['create', 'edit']);
