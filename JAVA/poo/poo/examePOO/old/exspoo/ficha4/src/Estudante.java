class Estudante {
	private String nome;
	private int [ ] notas;
	private float media;
	
	public Estudante() {
		System.out.print("Nome do estudante: ");
		nome = User.readString();
		System.out.print("Quantas notas? ");
		int numNotas = User.readInt();
		//Cria a tabela notas com a dimensão necessária
		notas = new int [numNotas];
		for (int i = 0; i < numNotas; i++) {
			System.out.print("Nota "+(i+1)+" deste aluno: ");
			notas[i] = User.readInt();
			}
		media = calculaMedia();
		}

//main
	public void imprimeEstudante() {
		System.out.print("As notas de "+nome+" são: ");
		for (int i = 0; i < notas.length; i++) {
		System.out.print(notas [i]+ " ");
		}
		System.out.println();
		System.out.println("A média é "+media);
		}
	
	
	public float getMedia() {
		return media;
		}

	private float calculaMedia() {
		float soma = 0;
		if (notas.length > 0){
		for (int i = 0; i < notas.length; i++) {
		soma += notas[i];
		}
		return soma / notas.length;
		} else return -1;
	}
	}
