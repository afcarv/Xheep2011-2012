
class Defesa extends Jogador {

	Defesa(String Nome,int n_camisola){
		super(Nome, n_camisola);
	}
	
	int num_rec = (int)(Math.random()*50);
	int num_faltas = (int)(Math.random()*50);
}
