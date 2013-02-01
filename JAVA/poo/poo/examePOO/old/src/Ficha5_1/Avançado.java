package Ficha5_1;

class Avançado extends Jogador {
	
	//super-> dados de um jogador coincidem com os de um avançado:
	public Avançado(String Nome, int numero) {
		super(Nome, numero);
	}

	int num_gmarcados = (int)(Math.random()*50);
}
