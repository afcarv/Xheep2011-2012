package Ficha5_1;

class Avan�ado extends Jogador {
	
	//super-> dados de um jogador coincidem com os de um avan�ado:
	public Avan�ado(String Nome, int numero) {
		super(Nome, numero);
	}

	int num_gmarcados = (int)(Math.random()*50);
}
