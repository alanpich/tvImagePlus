<?php

/**
 * Get the contents of a file, stripping out php tags
 * @param string $filename Path to file
 * @return string 
 */
function getSnippetContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}


/**
 * Parse the smarty readme tpl for packaging
 * @param string $path Path to tpl
 * @return string
 */
function getReadmeFile( $path ){
    global $modx;
    $modx->getService('smarty','smarty.modSmarty');
    
    $modx->smarty->assign('date',date("jS M Y g:ia"));
    $modx->smarty->assign('version',PKG_VERSION.' '.PKG_RELEASE);
    $modx->smarty->assign('commit',PKG_COMMIT);
    $readme = $modx->smarty->fetch($path);
    return $readme;
}//


/**
 * Get currect git commit id
 * @param string repoRoot Path to repository root
 * @return string commit hash
 */
function getGitCommitId( $repoRoot ){
   // Check git exists
    $whichGit = `which git`;
    if(empty($whichGit)){ return ''; };
    
   // Check we're in a git repo
    $gitFolder = str_replace('//','/',$repoRoot.'/.git');
    if( ! is_dir($gitFolder) ){ return ''; };
    
    // 
    $test = shell_exec("cd $repoRoot; git rev-parse HEAD;");
    return trim($test);
    
   
}//