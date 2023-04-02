package fr.iut2.saeprojet;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import java.util.Date;

import fr.iut2.saeprojet.api.APIClient;
import fr.iut2.saeprojet.api.ResultatAppel;
import fr.iut2.saeprojet.entity.Candidature;
import fr.iut2.saeprojet.entity.EtatCandidaturesResponse;
import fr.iut2.saeprojet.entity.Offre;

public class CandidatureActivity extends StageAppActivity {

    public static final String CANDIDATURE_KEY = "candidature_key";
    private Candidature candidature;

    private TextView candidatureTitle, candidatureStatus, candidatureTodo, candidatureTodoDate;
    private Button candidatureModify, candidatureConfirm;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_candidature);

        candidature = getIntent().getParcelableExtra(CANDIDATURE_KEY);

        candidatureTitle = findViewById(R.id.candidature_offre_title);
        candidatureStatus = findViewById(R.id.candidature_status);
        candidatureTodo = findViewById(R.id.candidature_todo);
        candidatureTodoDate = findViewById(R.id.candidature_todo_date);
        candidatureModify = findViewById(R.id.candidature_modify);
        candidatureConfirm = findViewById(R.id.candidature_confirm);

        String[] candidatureId = candidature.offre.split("/");
        String Id = candidatureId[candidatureId.length - 1];
        APIClient.getOffre(this, Long.valueOf(Id), new ResultatAppel<Offre>() {
            @Override
            public void traiterResultat(Offre response) {
                candidatureTitle.setText(response.intitule);
            }

            @Override
            public void traiterErreur() {

            }
        });

        APIClient.getEtatCandidatures(this, new ResultatAppel<EtatCandidaturesResponse>() {
            @Override
            public void traiterResultat(fr.iut2.saeprojet.entity.EtatCandidaturesResponse response) {
                for (fr.iut2.saeprojet.entity.EtatCandidature etatCandidature : response.etatCandidatures) {
                    if (etatCandidature._id.equals(candidature.etatCandidature)) {
                        candidatureStatus.setText(candidatureStatus.getText() + " " + etatCandidature.etat);
                    }
                }
            }

            @Override
            public void traiterErreur() {

            }
        });

        if (candidature.typeAction == null) {
            candidatureTodo.setText(candidatureTodo.getText() + " Pas d'action spécifiée");
        } else {
            candidatureTodo.setText(candidatureTodo.getText() + " " + candidature.typeAction);
        }

        // TODO: format date
        candidatureTodoDate.setText(candidatureTodoDate.getText() + " " + candidature.dateAction);

        String action = null;
        switch (candidature.etatCandidature) {
            case "/api/etat_candidatures/1":
            case "/api/etat_candidatures/2":
            case "/api/etat_candidatures/4":
            case "/api/etat_candidatures/5":
            case "/api/etat_candidatures/3":
                candidatureConfirm.setText(getResources().getString(R.string.candidatures_delete));
                action = "delete";
                break;
            case "/api/etat_candidatures/6":
                candidatureConfirm.setText(getResources().getString(R.string.candidatures_choose));
                action = "accept";
                break;
        }

        String[] offreId = candidature.offre.split("/");
        String stringOffreId = offreId[offreId.length - 1];
        APIClient.getOffre(this, Long.valueOf(stringOffreId), new ResultatAppel<Offre>() {
            @Override
            public void traiterResultat(Offre response) {
                candidatureModify.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        Intent intent = new Intent(CandidatureActivity.this, CandidatureModifyActivity.class);
                        intent.putExtra(CandidatureModifyActivity.ACTION_KEY, "modify");
                        intent.putExtra(CandidatureModifyActivity.OFFRE_KEY, response);
                        intent.putExtra(CandidatureModifyActivity.CANDIDATURE_KEY, candidature);
                        startActivity(intent);
                    }
                });
            }

            @Override
            public void traiterErreur() {

            }
        });

        String finalAction = action;
        candidatureConfirm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(CandidatureActivity.this, ConfirmActivity.class);
                intent.putExtra(ConfirmActivity.ACTION_KEY, finalAction);
                intent.putExtra(ConfirmActivity.CANDIDATURE_KEY, candidature);
                startActivity(intent);
            }
        });
    }
}