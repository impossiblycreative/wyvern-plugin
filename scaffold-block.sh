#!/bin/bash

# Set up the function
function scaffold_block( ) {
    # Prompt the user for the name of the block
    echo What is the block\'s name?
    read blockName

    # Move to the blocks directory
    cd blocks

    # Make the directory and enter it
    mkdir $blockName
    cd $blockName

    # Build our folders
    mkdir build
    mkdir css
    mkdir src

    # Enter CSS folder, create the necessary files, and return to the block folder
    cd css
    touch style.css
    touch editor.css
    cd ..

    # Enter SRC folder, create the necessary files, and return to the block folder
    cd src
    touch index.js
    touch render.php
    cd ..

    # Back out into the main plugin directory
    cd ..
}

# Run the scaffolding function
scaffold_block