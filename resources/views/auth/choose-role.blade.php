<h2>Choose Your Role</h2>

<form method="POST" action="/choose-role">
    @csrf

    <button type="submit" name="role" value="finder">
        Finder
    </button>

    <button type="submit" name="role" value="claimant">
        Claimant
    </button>
</form>