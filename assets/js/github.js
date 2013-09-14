GitHubRepo = function(user,repoName){

    this._baseUrl = 'https://api.github.com/';

    this.user = user;
    this.name = repoName;
    this._sig = user+'/'+repoName


    this.getOpenIssueCount = function(){
        var url = this._baseUrl + 'repos/'+this._sig+'/issues?callback=Repo._receiveOpenIssueCount';
        this.sendRequest(url);
    }

    this._receiveOpenIssueCount = function(response){
        var data = response.data
        this.openIssues = data.length;
        var elem = document.getElementById('repostatus_open-issues');
            elem.innerHTML = '<a href="https://github.com/alanpich/grideditor/issues" title="Visit issue tracker" target="_blank"   >'+this.openIssues+' open issues</a>'
    }


    this.getLastCommitDate = function(){
        var url = this._baseUrl + 'repos/'+this._sig+'/commits?callback=Repo._receiveLastCommitDate';
        this.sendRequest(url);
    }

    this._receiveLastCommitDate = function(response){
        var data = response.data
        this.lastCommit = data[0]


        $('.latest-commit .sha').html(this.lastCommit.sha);

    }






    this.sendRequest = function(url){
        var script = document.createElement('script');
            script.src = url;
            script.onload = function(){
                this.parentNode.removeChild(this);
            }
        document.getElementsByTagName('head')[0].appendChild(script);
    }

}


Repo = new GitHubRepo('alanpich','grideditor');

Repo.getOpenIssueCount();
Repo.getLastCommitDate();
