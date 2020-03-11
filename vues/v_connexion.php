<div id="contenu">
      <h2>Identification utilisateur</h2>
      <form method="POST" action="index.php?uc=connexion&action=valideConnexion" class="form-row">
            <div class="form-group mb-4 sm-2">
                  <label for="nom">Login*</label>
                  <input id="login" class="form-control" type="text" name="login" size="30" maxlength="45">

                  <label for="mdp">Mot de passe*</label>
                  <input id="mdp" class="form-control" type="password" name="mdp" size="30" maxlength="45">
                  <br>
                  <input type="submit" class="btn btn-primary" value="Valider" name="valider">
                  <input type="reset" class="btn btn-secondary" value="Annuler" name="annuler">
            </div>
      </form>
</div>