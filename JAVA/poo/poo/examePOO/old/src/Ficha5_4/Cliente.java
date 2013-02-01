package Ficha5_4;
public class Cliente extends Jogador
{	
	//construtor- herda  nome e idade de jogador + telefone
	public Cliente(String 	_name, int _age, int _telephone)
	{
		super(_name, _age, _telephone);
	}

	protected void init()
	{	
		//limite de apostas:
		super.init();
		betLimit = 3;
	}
}