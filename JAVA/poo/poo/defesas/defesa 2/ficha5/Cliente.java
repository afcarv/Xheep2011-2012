public class Cliente extends Jogador
{
	public Cliente(String 	_name, int _age, int _telephone)
	{
		super(_name, _age, _telephone);
	}

	protected void init()
	{
		super.init();
		betLimit = 3;
	}
}