CREATE ALGORITHM = UNDEFINED VIEW classroom_group_view(
groupId,
groupCode,
groupShortName,
groupName,
groupDescription,
educationalLevelId,
grade,
mentorId
) AS SELECT group_id, codi_grup, nom_grup, nom_grup AS groupName, descripcio, nivell_educatiu, grau AS grade, tutor
FROM webfaltes.grup
