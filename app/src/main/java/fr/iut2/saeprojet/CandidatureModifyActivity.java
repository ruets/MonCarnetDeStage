package fr.iut2.saeprojet;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.TextView;

import fr.iut2.saeprojet.api.APIClient;
import fr.iut2.saeprojet.api.ResultatAppel;
import fr.iut2.saeprojet.entity.Candidature;
import fr.iut2.saeprojet.entity.CandidatureRequest;
import fr.iut2.saeprojet.entity.EtatCandidature;
import fr.iut2.saeprojet.entity.EtatCandidaturesResponse;
import fr.iut2.saeprojet.entity.Offre;

public class CandidatureModifyActivity extends StageAppActivity {
    public static final String ACTION_KEY = "action_key";
    public static final String CANDIDATURE_KEY = "candidature_key";
    public static final String OFFRE_KEY = "offre_key";
    private String action;
    private Candidature candidature;
    private Offre offre;

    private TextView offreTitle, todo, todoDate;
    private Spinner status;
    private Button finalize;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_candidature_modify);

        action = getIntent().getStringExtra(ACTION_KEY);
        candidature = getIntent().getParcelableExtra(CANDIDATURE_KEY);
        offre = getIntent().getParcelableExtra(OFFRE_KEY);

        offreTitle = findViewById(R.id.modify_candidature_offre_title);
        status = findViewById(R.id.modify_candidature_status);
        todo = findViewById(R.id.modify_candidature_todo);
        todoDate = findViewById(R.id.modify_candidature_todo_date);
        finalize = findViewById(R.id.modify_candidature_finalize);

        offreTitle.setText(offre.intitule);

        APIClient.getEtatCandidatures(this, new ResultatAppel<EtatCandidaturesResponse>() {
            @Override
            public void traiterResultat(EtatCandidaturesResponse response) {
                ArrayAdapter<EtatCandidature> adapter = new ArrayAdapter<>(CandidatureModifyActivity.this, android.R.layout.simple_spinner_item, response.etatCandidatures);
                adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                status.setAdapter(adapter);
            }

            @Override
            public void traiterErreur() {}
        });

        if (action.equals("create")) {
            finalize.setText(getResources().getText(R.string.candidatures_finalize));
            finalize.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    CandidatureRequest candidatureRequest = new CandidatureRequest();
                    candidatureRequest.etatCandidature = status.getSelectedItem().toString();
                    candidatureRequest.offre = offre._id;
                    candidatureRequest.typeAction = todo.getText().toString();
                    candidatureRequest.dateAction = todoDate.getText().toString();

                    APIClient.createCandidature(CandidatureModifyActivity.this, candidatureRequest, new ResultatAppel<Candidature>() {
                        @Override
                        public void traiterResultat(Candidature response) {
                            finish();
                        }

                        @Override
                        public void traiterErreur() {}
                    });
                }
            });
        } else if (action.equals("modify")) {
            finalize.setText(getResources().getText(R.string.candidatures_save));
        }

    }
}