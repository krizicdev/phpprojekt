<?php
// Created/Modified files during execution:
// logout.php

include 'config.php';

// Destroy session
session_destroy();

header("Location: index.php");
exit;