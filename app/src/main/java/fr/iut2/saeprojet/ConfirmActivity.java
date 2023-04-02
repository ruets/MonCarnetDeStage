package fr.iut2.saeprojet;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import fr.iut2.saeprojet.api.APIClient;
import fr.iut2.saeprojet.api.ResultatAppel;
import fr.iut2.saeprojet.entity.Candidature;
import fr.iut2.saeprojet.entity.Offre;

public class ConfirmActivity extends StageAppActivity {
    public static final String ACTION_KEY = "action_key";
    public static final String CANDIDATURE_KEY = "candidature_key";

    String action;
    private Candidature candidature;

    TextView confirmOffreTitle, confirmText;
    Button confirmYes, confirmNo;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_confirm);

        action = getIntent().getExtras().getString(ACTION_KEY);
        candidature = (Candidature) getIntent().getParcelableExtra(CANDIDATURE_KEY);

        confirmOffreTitle = findViewById(R.id.confirm_offre_title);
        confirmText = findViewById(R.id.confirm_text);
        confirmYes = findViewById(R.id.confirm_yes);
        confirmNo = findViewById(R.id.confirm_no);

        if (candidature != null && action != null) {
            APIClient.getOffre(this, Long.valueOf(candidature.getOffreId()), new ResultatAppel<Offre>() {
                @Override
                public void traiterResultat(Offre response) {
                    confirmOffreTitle.setText(response.intitule);
                }

                @Override
                public void traiterErreur() {
                }
            });

            confirmNo.setOnClickListener(v -> finish());

            if (action.equals("delete")) {
                confirmText.setText(getResources().getString(R.string.candidatures_confirm_delete));
                confirmYes.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        APIClient.removeCandidature(ConfirmActivity.this, candidature.id, new ResultatAppel<Candidature>() {
                            @Override
                            public void traiterResultat(Candidature response) {
                                Intent intent = new Intent(ConfirmActivity.this, MainActivity.class);
                                startActivity(intent);

                                finish();
                            }

                            @Override
                            public void traiterErreur() {}
                        });
                    }
                });
            } else if (action.equals("accept")) {
                confirmText.setText(getResources().getString(R.string.candidatures_confirm_accept));

                confirmYes.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                          //TODO
//                        APIClient.acceptCandidature(ConfirmActivity.this, candidature.id, new ResultatAppel<Candidature>() {
//                            @Override
//                            public void traiterResultat(Candidature response) {
//                                Intent intent = new Intent(ConfirmActivity.this, MainActivity.class);
//                                startActivity(intent);
//
//                                finish();
//                            }
//
//                            @Override
//                            public void traiterErreur() {}
//                        });
                    }
                });
            }
        }
    }
}